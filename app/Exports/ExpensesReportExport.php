<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithEvents;
use PHPExcel_Worksheet_PageSetup;
use DB;
use App\Expense;

class ExpensesReportExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldAutoSize
{
	protected $data;

	function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		$start_date = date('Y-m-d', strtotime($this->data['start_date']));
		$end_date = date("Y-m-d", strtotime($this->data['end_date']));
		$expenses = Expense::with(['attachments']);
		if (!empty($this->data['driver'])) {
			$expenses = $expenses->where(['driver_id' => $this->data['driver']]);
		}
		$expenses =	$expenses->where(function ($query) use ($start_date, $end_date) {
			$query->whereRaw("Date(created_at) >= ? && Date(created_at) <= ?", [$start_date, $end_date]);
		})->get();
		return $expenses;
	}

	public function map($expenses): array
	{
		$attachments = [];
		if(!empty($expenses->attachments) && count($expenses->attachments)){
			foreach($expenses->attachments as $attachment_value){
				$attachments[] = url('storage/app/public/'.$attachment_value->url);
			}
		}

		return [
			date('d M, Y h:i a', strtotime($expenses->created_at)),
			date("W",strtotime($expenses->created_at)),
			$expenses->driver->first_name . ' ' . $expenses->driver->last_name,
			$expenses->amount,
			$expenses->type,
			$expenses->ride_id,
			$expenses->note,
			(!empty($attachments))?(implode(";",$attachments)):""
		];
	}

	public function headings(): array
	{
		return [
			[
				"Date",
				"Week",
				"Driver Name",
				"Cost",
				"Expense Type",
				"Ride ID",
				"Note",
				"Expense Scan"
			],
		];
	}

	public function title(): string
	{
		return 'Expense Report Veldoo';
	}
}
