/*
 * International Telephone Input v9.0.10
 * https://github.com/jackocnr/intl-tel-input.git
 * Licensed under the MIT license
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],function(b){a(b,window,document)}):"object"==typeof module&&module.exports?module.exports=a(require("jquery"),window,document):a(jQuery,window,document)}(function(a,b,c,d){"use strict";function e(b,c){this.a=a(b),c&&(a.extend(c,c,{a:c.allowDropdown,b:c.autoHideDialCode,c:c.autoPlaceholder,c2:c.customPlaceholder,d:c.dropdownContainer,e:c.excludeCountries,f:c.formatOnInit,g:c.geoIpLookup,h:c.initialCountry,i:c.nationalMode,j:c.numberType,k:c.onlyCountries,l:c.preferredCountries,m:c.separateDialCode,n:c.utilsScript})),this.b=a.extend({},h,c),this.ns="."+f+g++,this.d=Boolean(b.setSelectionRange),this.e=Boolean(a(b).attr("placeholder"))}var f="intlTelInput",g=1,h={a:!0,b:!0,c:!0,c2:null,d:"",e:[],f:!0,g:null,h:"",i:!0,j:"MOBILE",k:[],l:["us","gb"],m:!1,n:""},i={b:38,c:40,d:13,e:27,f:43,A:65,Z:90,j:32,k:9};a(b).on("load",function(){a.fn[f].windowLoaded=!0}),e.prototype={_a:function(){return this.b.i&&(this.b.b=!1),this.b.m&&(this.b.b=this.b.i=!1,this.b.a=!0),this.g=/Android.+Mobile|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),this.g&&(a("body").addClass("iti-mobile"),this.b.d||(this.b.d="body")),this.h=new a.Deferred,this.i=new a.Deferred,this._b(),this._f(),this._h(),this._i(),this._i2(),[this.h,this.i]},_b:function(){this._d(),this._d2(),this._e()},_c:function(a,b,c){b in this.q||(this.q[b]=[]);var d=c||0;this.q[b][d]=a},_c2:function(b,c){var d;for(d=0;d<b.length;d++)b[d]=b[d].toLowerCase();for(this.p=[],d=0;d<j.length;d++)c(a.inArray(j[d].iso2,b))&&this.p.push(j[d])},_d:function(){this.b.k.length?this._c2(this.b.k,function(a){return-1!=a}):this.b.e.length?this._c2(this.b.e,function(a){return-1==a}):this.p=j},_d2:function(){this.q={};for(var a=0;a<this.p.length;a++){var b=this.p[a];if(this._c(b.iso2,b.dialCode,b.priority),b.areaCodes)for(var c=0;c<b.areaCodes.length;c++)this._c(b.iso2,b.dialCode+b.areaCodes[c])}},_e:function(){this.r=[];for(var a=0;a<this.b.l.length;a++){var b=this.b.l[a].toLowerCase(),c=this._y(b,!1,!0);c&&this.r.push(c)}},_f:function(){this.a.attr("autocomplete","off");var b="intl-tel-input";this.b.a&&(b+=" allow-dropdown"),this.b.m&&(b+=" separate-dial-code"),this.a.wrap(a("<div>",{"class":b})),this.k=a("<div>",{"class":"flag-container"}).insertBefore(this.a);var c=a("<div>",{"class":"selected-flag"});c.appendTo(this.k),this.l=a("<div>",{"class":"iti-flag"}).appendTo(c),this.b.m&&(this.t=a("<div>",{"class":"selected-dial-code"}).appendTo(c)),this.b.a?(c.attr("tabindex","0"),a("<div>",{"class":"iti-arrow"}).appendTo(c),this.m=a("<ul>",{"class":"country-list hide"}),this.r.length&&(this._g(this.r,"preferred"),a("<li>",{"class":"divider"}).appendTo(this.m)),this._g(this.p,""),this.o=this.m.children(".country"),this.b.d?this.dropdown=a("<div>",{"class":"intl-tel-input iti-container"}).append(this.m):this.m.appendTo(this.k)):this.o=a()},_g:function(a,b){for(var c="",d=0;d<a.length;d++){var e=a[d];c+="<li class='country "+b+"' data-dial-code='"+e.dialCode+"' data-country-code='"+e.iso2+"'>",c+="<div class='flag-box'><div class='iti-flag "+e.iso2+"'></div></div>",c+="<span class='country-name'>"+e.name+"</span>",c+="<span class='dial-code'>+"+e.dialCode+"</span>",c+="</li>"}this.m.append(c)},_h:function(){var a=this.a.val();this._af(a)?this._v(a,!0):"auto"!==this.b.h&&(this.b.h?this._z(this.b.h,!0):(this.j=this.r.length?this.r[0].iso2:this.p[0].iso2,a||this._z(this.j,!0)),a||this.b.i||this.b.b||this.b.m||this.a.val("+"+this.s.dialCode)),a&&this._u(a,this.b.f)},_i:function(){this._j(),this.b.b&&this._l(),this.b.a&&this._i1()},_i1:function(){var a=this,b=this.a.closest("label");b.length&&b.on("click"+this.ns,function(b){a.m.hasClass("hide")?a.a.focus():b.preventDefault()});var c=this.l.parent();c.on("click"+this.ns,function(){!a.m.hasClass("hide")||a.a.prop("disabled")||a.a.prop("readonly")||a._n()}),this.k.on("keydown"+a.ns,function(b){var c=a.m.hasClass("hide");!c||b.which!=i.b&&b.which!=i.c&&b.which!=i.j&&b.which!=i.d||(b.preventDefault(),b.stopPropagation(),a._n()),b.which==i.k&&a._ac()})},_i2:function(){var c=this;this.b.n?a.fn[f].windowLoaded?a.fn[f].loadUtils(this.b.n,this.i):a(b).on("load",function(){a.fn[f].loadUtils(c.b.n,c.i)}):this.i.resolve(),"auto"===this.b.h?this._i3():this.h.resolve()},_i3:function(){a.fn[f].autoCountry?this.handleAutoCountry():a.fn[f].startedLoadingAutoCountry||(a.fn[f].startedLoadingAutoCountry=!0,"function"==typeof this.b.g&&this.b.g(function(b){a.fn[f].autoCountry=b.toLowerCase(),setTimeout(function(){a(".intl-tel-input input").intlTelInput("handleAutoCountry")})}))},_j:function(){var a=this;this.a.on("keyup"+this.ns,function(){a._v(a.a.val())}),this.a.on("cut"+this.ns+" paste"+this.ns,function(){setTimeout(function(){a._v(a.a.val())})})},_j2:function(a){var b=this.a.attr("maxlength");return b&&a.length>b?a.substr(0,b):a},_l:function(){var b=this;this.a.on("mousedown"+this.ns,function(a){b.a.is(":focus")||b.a.val()||(a.preventDefault(),b.a.focus())}),this.a.on("focus"+this.ns,function(){b.a.val()||b.a.prop("readonly")||!b.s.dialCode||(b.a.val("+"+b.s.dialCode),b.a.one("keypress.plus"+b.ns,function(a){a.which==i.f&&b.a.val("")}),setTimeout(function(){var a=b.a[0];if(b.d){var c=b.a.val().length;a.setSelectionRange(c,c)}}))});var c=this.a.prop("form");c&&a(c).on("submit"+this.ns,function(){b._removeEmptyDialCode()}),this.a.on("blur"+this.ns,function(){b._removeEmptyDialCode()})},_removeEmptyDialCode:function(){var a=this.a.val(),b="+"==a.charAt(0);if(b){var c=this._m(a);c&&this.s.dialCode!=c||this.a.val("")}this.a.off("keypress.plus"+this.ns)},_m:function(a){return a.replace(/\D/g,"")},_n:function(){this._o();var a=this.m.children(".active");a.length&&(this._x(a),this._ad(a)),this._p(),this.l.children(".iti-arrow").addClass("up")},_o:function(){var c=this;if(this.b.d&&this.dropdown.appendTo(this.b.d),this.n=this.m.removeClass("hide").outerHeight(),!this.g){var d=this.a.offset(),e=d.top,f=a(b).scrollTop(),g=e+this.a.outerHeight()+this.n<f+a(b).height(),h=e-this.n>f;if(this.m.toggleClass("dropup",!g&&h),this.b.d){var i=!g&&h?0:this.a.innerHeight();this.dropdown.css({top:e+i,left:d.left}),a(b).on("scroll"+this.ns,function(){c._ac()})}}},_p:function(){var b=this;this.m.on("mouseover"+this.ns,".country",function(){b._x(a(this))}),this.m.on("click"+this.ns,".country",function(){b._ab(a(this))});var d=!0;a("html").on("click"+this.ns,function(){d||b._ac(),d=!1});var e="",f=null;a(c).on("keydown"+this.ns,function(a){a.preventDefault(),a.which==i.b||a.which==i.c?b._q(a.which):a.which==i.d?b._r():a.which==i.e?b._ac():(a.which>=i.A&&a.which<=i.Z||a.which==i.j)&&(f&&clearTimeout(f),e+=String.fromCharCode(a.which),b._s(e),f=setTimeout(function(){e=""},1e3))})},_q:function(a){var b=this.m.children(".highlight").first(),c=a==i.b?b.prev():b.next();c.length&&(c.hasClass("divider")&&(c=a==i.b?c.prev():c.next()),this._x(c),this._ad(c))},_r:function(){var a=this.m.children(".highlight").first();a.length&&this._ab(a)},_s:function(a){for(var b=0;b<this.p.length;b++)if(this._t(this.p[b].name,a)){var c=this.m.children("[data-country-code="+this.p[b].iso2+"]").not(".preferred");this._x(c),this._ad(c,!0);break}},_t:function(a,b){return a.substr(0,b.length).toUpperCase()==b},_u:function(a,c){if(c&&b.intlTelInputUtils&&this.s){var d=this.b.m||!this.b.i&&"+"==a.charAt(0)?intlTelInputUtils.numberFormat.INTERNATIONAL:intlTelInputUtils.numberFormat.NATIONAL;a=intlTelInputUtils.formatNumber(a,this.s.iso2,d)}a=this._ah(a),this.a.val(a)},_v:function(b,c){b&&this.b.i&&this.s&&"1"==this.s.dialCode&&"+"!=b.charAt(0)&&("1"!=b.charAt(0)&&(b="1"+b),b="+"+b);var d=this._af(b),e=null;if(d){var f=this.q[this._m(d)],g=this.s&&-1!=a.inArray(this.s.iso2,f);if(!g||this._w(b,d))for(var h=0;h<f.length;h++)if(f[h]){e=f[h];break}}else"+"==b.charAt(0)&&this._m(b).length?e="":b&&"+"!=b||(e=this.j);null!==e&&this._z(e,c)},_w:function(a,b){return"+1"==b&&this._m(a).length>=4},_x:function(a){this.o.removeClass("highlight"),a.addClass("highlight")},_y:function(a,b,c){for(var d=b?j:this.p,e=0;e<d.length;e++)if(d[e].iso2==a)return d[e];if(c)return null;throw new Error("No country data for '"+a+"'")},_z:function(a,b){var c=this.s&&this.s.iso2?this.s:{};this.s=a?this._y(a,!1,!1):{},this.s.iso2&&(this.j=this.s.iso2),this.l.attr("class","iti-flag "+a);var d=a?this.s.name+": +"+this.s.dialCode:"Unknown";if(this.l.parent().attr("title",d),this.b.m){var e=this.s.dialCode?"+"+this.s.dialCode:"",f=this.a.parent();c.dialCode&&f.removeClass("iti-sdc-"+(c.dialCode.length+1)),e&&f.addClass("iti-sdc-"+e.length),this.t.text(e)}this._aa(),this.o.removeClass("active"),a&&this.o.find(".iti-flag."+a).first().closest(".country").addClass("active"),b||c.iso2===a||this.a.trigger("countrychange",this.s)},_aa:function(){if(b.intlTelInputUtils&&!this.e&&this.b.c&&this.s){var a=intlTelInputUtils.numberType[this.b.j],c=this.s.iso2?intlTelInputUtils.getExampleNumber(this.s.iso2,this.b.i,a):"";c=this._ah(c),"function"==typeof this.b.c2&&(c=this.b.c2(c,this.s)),this.a.attr("placeholder",c)}},_ab:function(a){if(this._z(a.attr("data-country-code")),this._ac(),this._ae(a.attr("data-dial-code"),!0),this.a.focus(),this.d){var b=this.a.val().length;this.a[0].setSelectionRange(b,b)}},_ac:function(){this.m.addClass("hide"),this.l.children(".iti-arrow").removeClass("up"),a(c).off(this.ns),a("html").off(this.ns),this.m.off(this.ns),this.b.d&&(this.g||a(b).off("scroll"+this.ns),this.dropdown.detach())},_ad:function(a,b){var c=this.m,d=c.height(),e=c.offset().top,f=e+d,g=a.outerHeight(),h=a.offset().top,i=h+g,j=h-e+c.scrollTop(),k=d/2-g/2;if(e>h)b&&(j-=k),c.scrollTop(j);else if(i>f){b&&(j+=k);var l=d-g;c.scrollTop(j-l)}},_ae:function(a,b){var c,d=this.a.val();if(a="+"+a,"+"==d.charAt(0)){var e=this._af(d);c=e?d.replace(e,a):a}else{if(this.b.i||this.b.m)return;if(d)c=a+d;else{if(!b&&this.b.b)return;c=a}}this.a.val(c)},_af:function(b){var c="";if("+"==b.charAt(0))for(var d="",e=0;e<b.length;e++){var f=b.charAt(e);if(a.isNumeric(f)&&(d+=f,this.q[d]&&(c=b.substr(0,e+1)),4==d.length))break}return c},_ag:function(){var a=this.b.m?"+"+this.s.dialCode:"";return a+this.a.val()},_ah:function(a){if(this.b.m){var b=this._af(a);if(b){null!==this.s.areaCodes&&(b="+"+this.s.dialCode);var c=" "===a[b.length]||"-"===a[b.length]?b.length+1:b.length;a=a.substr(c)}}return this._j2(a)},handleAutoCountry:function(){"auto"===this.b.h&&(this.j=a.fn[f].autoCountry,this.a.val()||this.setCountry(this.j),this.h.resolve())},destroy:function(){if(this.allowDropdown&&(this._ac(),this.l.parent().off(this.ns),this.a.closest("label").off(this.ns)),this.b.b){var b=this.a.prop("form");b&&a(b).off(this.ns)}this.a.off(this.ns);var c=this.a.parent();c.before(this.a).remove()},getExtension:function(){return b.intlTelInputUtils?intlTelInputUtils.getExtension(this._ag(),this.s.iso2):""},getNumber:function(a){return b.intlTelInputUtils?intlTelInputUtils.formatNumber(this._ag(),this.s.iso2,a):""},getNumberType:function(){return b.intlTelInputUtils?intlTelInputUtils.getNumberType(this._ag(),this.s.iso2):-99},getSelectedCountryData:function(){return this.s||{}},getValidationError:function(){return b.intlTelInputUtils?intlTelInputUtils.getValidationError(this._ag(),this.s.iso2):-99},isValidNumber:function(){var c=a.trim(this._ag()),d=this.b.i?this.s.iso2:"";return b.intlTelInputUtils?intlTelInputUtils.isValidNumber(c,d):null},setCountry:function(a){a=a.toLowerCase(),this.l.hasClass(a)||(this._z(a),this._ae(this.s.dialCode,!1))},setNumber:function(a,b){this._v(a),this._u(a,!b)},handleUtils:function(){b.intlTelInputUtils&&(this.a.val()&&this._u(this.a.val(),this.b.f),this._aa()),this.i.resolve()}},a.fn[f]=function(b){var c=arguments;if(b===d||"object"==typeof b){var g=[];return this.each(function(){if(!a.data(this,"plugin_"+f)){var c=new e(this,b),d=c._a();g.push(d[0]),g.push(d[1]),a.data(this,"plugin_"+f,c)}}),a.when.apply(null,g)}if("string"==typeof b&&"_"!==b[0]){var h;return this.each(function(){var d=a.data(this,"plugin_"+f);d instanceof e&&"function"==typeof d[b]&&(h=d[b].apply(d,Array.prototype.slice.call(c,1))),"destroy"===b&&a.data(this,"plugin_"+f,null)}),h!==d?h:this}},a.fn[f].getCountryData=function(){return j},a.fn[f].loadUtils=function(b,c){a.fn[f].loadedUtilsScript?c&&c.resolve():(a.fn[f].loadedUtilsScript=!0,a.ajax({url:b,complete:function(){a(".intl-tel-input input").intlTelInput("handleUtils")},dataType:"script",cache:!0}))},a.fn[f].version="9.0.10";for(var j=[["Afghanistan (â€«Ø§ÙØºØ§Ù†Ø³ØªØ§Ù†â€¬â€Ž)","af","93"],["Albania (ShqipÃ«ri)","al","355"],["Algeria (â€«Ø§Ù„Ø¬Ø²Ø§Ø¦Ø±â€¬â€Ž)","dz","213"],["American Samoa","as","1684"],["Andorra","ad","376"],["Angola","ao","244"],["Anguilla","ai","1264"],["Antigua and Barbuda","ag","1268"],["Argentina","ar","54"],["Armenia (Õ€Õ¡ÕµÕ¡Õ½Õ¿Õ¡Õ¶)","am","374"],["Aruba","aw","297"],["Australia","au","61",0],["Austria (Ã–sterreich)","at","43"],["Azerbaijan (AzÉ™rbaycan)","az","994"],["Bahamas","bs","1242"],["Bahrain (â€«Ø§Ù„Ø¨Ø­Ø±ÙŠÙ†â€¬â€Ž)","bh","973"],["Bangladesh (à¦¬à¦¾à¦‚à¦²à¦¾à¦¦à§‡à¦¶)","bd","880"],["Barbados","bb","1246"],["Belarus (Ð‘ÐµÐ»Ð°Ñ€ÑƒÑÑŒ)","by","375"],["Belgium (BelgiÃ«)","be","32"],["Belize","bz","501"],["Benin (BÃ©nin)","bj","229"],["Bermuda","bm","1441"],["Bhutan (à½ à½–à¾²à½´à½‚)","bt","975"],["Bolivia","bo","591"],["Bosnia and Herzegovina (Ð‘Ð¾ÑÐ½Ð° Ð¸ Ð¥ÐµÑ€Ñ†ÐµÐ³Ð¾Ð²Ð¸Ð½Ð°)","ba","387"],["Botswana","bw","267"],["Brazil (Brasil)","br","55"],["British Indian Ocean Territory","io","246"],["British Virgin Islands","vg","1284"],["Brunei","bn","673"],["Bulgaria (Ð‘ÑŠÐ»Ð³Ð°Ñ€Ð¸Ñ)","bg","359"],["Burkina Faso","bf","226"],["Burundi (Uburundi)","bi","257"],["Cambodia (áž€áž˜áŸ’áž–áž»áž‡áž¶)","kh","855"],["Cameroon (Cameroun)","cm","237"],["Canada","ca","1",1,["204","226","236","249","250","289","306","343","365","387","403","416","418","431","437","438","450","506","514","519","548","579","581","587","604","613","639","647","672","705","709","742","778","780","782","807","819","825","867","873","902","905"]],["Cape Verde (Kabu Verdi)","cv","238"],["Caribbean Netherlands","bq","599",1],["Cayman Islands","ky","1345"],["Central African Republic (RÃ©publique centrafricaine)","cf","236"],["Chad (Tchad)","td","235"],["Chile","cl","56"],["China (ä¸­å›½)","cn","86"],["Christmas Island","cx","61",2],["Cocos (Keeling) Islands","cc","61",1],["Colombia","co","57"],["Comoros (â€«Ø¬Ø²Ø± Ø§Ù„Ù‚Ù…Ø±â€¬â€Ž)","km","269"],["Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)","cd","243"],["Congo (Republic) (Congo-Brazzaville)","cg","242"],["Cook Islands","ck","682"],["Costa Rica","cr","506"],["CÃ´te dâ€™Ivoire","ci","225"],["Croatia (Hrvatska)","hr","385"],["Cuba","cu","53"],["CuraÃ§ao","cw","599",0],["Cyprus (ÎšÏÏ€ÏÎ¿Ï‚)","cy","357"],["Czech Republic (ÄŒeskÃ¡ republika)","cz","420"],["Denmark (Danmark)","dk","45"],["Djibouti","dj","253"],["Dominica","dm","1767"],["Dominican Republic (RepÃºblica Dominicana)","do","1",2,["809","829","849"]],["Ecuador","ec","593"],["Egypt (â€«Ù…ØµØ±â€¬â€Ž)","eg","20"],["El Salvador","sv","503"],["Equatorial Guinea (Guinea Ecuatorial)","gq","240"],["Eritrea","er","291"],["Estonia (Eesti)","ee","372"],["Ethiopia","et","251"],["Falkland Islands (Islas Malvinas)","fk","500"],["Faroe Islands (FÃ¸royar)","fo","298"],["Fiji","fj","679"],["Finland (Suomi)","fi","358",0],["France","fr","33"],["French Guiana (Guyane franÃ§aise)","gf","594"],["French Polynesia (PolynÃ©sie franÃ§aise)","pf","689"],["Gabon","ga","241"],["Gambia","gm","220"],["Georgia (áƒ¡áƒáƒ¥áƒáƒ áƒ—áƒ•áƒ”áƒšáƒ)","ge","995"],["Germany (Deutschland)","de","49"],["Ghana (Gaana)","gh","233"],["Gibraltar","gi","350"],["Greece (Î•Î»Î»Î¬Î´Î±)","gr","30"],["Greenland (Kalaallit Nunaat)","gl","299"],["Grenada","gd","1473"],["Guadeloupe","gp","590",0],["Guam","gu","1671"],["Guatemala","gt","502"],["Guernsey","gg","44",1],["Guinea (GuinÃ©e)","gn","224"],["Guinea-Bissau (GuinÃ© Bissau)","gw","245"],["Guyana","gy","592"],["Haiti","ht","509"],["Honduras","hn","504"],["Hong Kong (é¦™æ¸¯)","hk","852"],["Hungary (MagyarorszÃ¡g)","hu","36"],["Iceland (Ãsland)","is","354"],["India (भारत)","in","91"],["Indonesia","id","62"],["Iran (â€«Ø§ÛŒØ±Ø§Ù†â€¬â€Ž)","ir","98"],["Iraq (â€«Ø§Ù„Ø¹Ø±Ø§Ù‚â€¬â€Ž)","iq","964"],["Ireland","ie","353"],["Isle of Man","im","44",2],["Israel (â€«×™×©×¨××œâ€¬â€Ž)","il","972"],["Italy (Italia)","it","39",0],["Jamaica","jm","1876"],["Japan (æ—¥æœ¬)","jp","81"],["Jersey","je","44",3],["Jordan (â€«Ø§Ù„Ø£Ø±Ø¯Ù†â€¬â€Ž)","jo","962"],["Kazakhstan (ÐšÐ°Ð·Ð°Ñ…ÑÑ‚Ð°Ð½)","kz","7",1],["Kenya","ke","254"],["Kiribati","ki","686"],["Kosovo","xk","383"],["Kuwait (â€«Ø§Ù„ÙƒÙˆÙŠØªâ€¬â€Ž)","kw","965"],["Kyrgyzstan (ÐšÑ‹Ñ€Ð³Ñ‹Ð·ÑÑ‚Ð°Ð½)","kg","996"],["Laos (àº¥àº²àº§)","la","856"],["Latvia (Latvija)","lv","371"],["Lebanon (â€«Ù„Ø¨Ù†Ø§Ù†â€¬â€Ž)","lb","961"],["Lesotho","ls","266"],["Liberia","lr","231"],["Libya (â€«Ù„ÙŠØ¨ÙŠØ§â€¬â€Ž)","ly","218"],["Liechtenstein","li","423"],["Lithuania (Lietuva)","lt","370"],["Luxembourg","lu","352"],["Macau (æ¾³é–€)","mo","853"],["Macedonia (FYROM) (ÐœÐ°ÐºÐµÐ´Ð¾Ð½Ð¸Ñ˜Ð°)","mk","389"],["Madagascar (Madagasikara)","mg","261"],["Malawi","mw","265"],["Malaysia","my","60"],["Maldives","mv","960"],["Mali","ml","223"],["Malta","mt","356"],["Marshall Islands","mh","692"],["Martinique","mq","596"],["Mauritania (â€«Ù…ÙˆØ±ÙŠØªØ§Ù†ÙŠØ§â€¬â€Ž)","mr","222"],["Mauritius (Moris)","mu","230"],["Mayotte","yt","262",1],["Mexico (MÃ©xico)","mx","52"],["Micronesia","fm","691"],["Moldova (Republica Moldova)","md","373"],["Monaco","mc","377"],["Mongolia (ÐœÐ¾Ð½Ð³Ð¾Ð»)","mn","976"],["Montenegro (Crna Gora)","me","382"],["Montserrat","ms","1664"],["Morocco (â€«Ø§Ù„Ù…ØºØ±Ø¨â€¬â€Ž)","ma","212",0],["Mozambique (MoÃ§ambique)","mz","258"],["Myanmar (Burma) (á€™á€¼á€”á€ºá€™á€¬)","mm","95"],["Namibia (NamibiÃ«)","na","264"],["Nauru","nr","674"],["Nepal (à¤¨à¥‡à¤ªà¤¾à¤²)","np","977"],["Netherlands (Nederland)","nl","31"],["New Caledonia (Nouvelle-CalÃ©donie)","nc","687"],["New Zealand","nz","64"],["Nicaragua","ni","505"],["Niger (Nijar)","ne","227"],["Nigeria","ng","234"],["Niue","nu","683"],["Norfolk Island","nf","672"],["North Korea (ì¡°ì„  ë¯¼ì£¼ì£¼ì˜ ì¸ë¯¼ ê³µí™”êµ­)","kp","850"],["Northern Mariana Islands","mp","1670"],["Norway (Norge)","no","47",0],["Oman (â€«Ø¹ÙÙ…Ø§Ù†â€¬â€Ž)","om","968"],["Pakistan (â€«Ù¾Ø§Ú©Ø³ØªØ§Ù†â€¬â€Ž)","pk","92"],["Palau","pw","680"],["Palestine (â€«ÙÙ„Ø³Ø·ÙŠÙ†â€¬â€Ž)","ps","970"],["Panama (PanamÃ¡)","pa","507"],["Papua New Guinea","pg","675"],["Paraguay","py","595"],["Peru (PerÃº)","pe","51"],["Philippines","ph","63"],["Poland (Polska)","pl","48"],["Portugal","pt","351"],["Puerto Rico","pr","1",3,["787","939"]],["Qatar (â€«Ù‚Ø·Ø±â€¬â€Ž)","qa","974"],["RÃ©union (La RÃ©union)","re","262",0],["Romania (RomÃ¢nia)","ro","40"],["Russia (Ð Ð¾ÑÑÐ¸Ñ)","ru","7",0],["Rwanda","rw","250"],["Saint BarthÃ©lemy (Saint-BarthÃ©lemy)","bl","590",1],["Saint Helena","sh","290"],["Saint Kitts and Nevis","kn","1869"],["Saint Lucia","lc","1758"],["Saint Martin (Saint-Martin (partie franÃ§aise))","mf","590",2],["Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)","pm","508"],["Saint Vincent and the Grenadines","vc","1784"],["Samoa","ws","685"],["San Marino","sm","378"],["SÃ£o TomÃ© and PrÃ­ncipe (SÃ£o TomÃ© e PrÃ­ncipe)","st","239"],["Saudi Arabia (â€«Ø§Ù„Ù…Ù…Ù„ÙƒØ© Ø§Ù„Ø¹Ø±Ø¨ÙŠØ© Ø§Ù„Ø³Ø¹ÙˆØ¯ÙŠØ©â€¬â€Ž)","sa","966"],["Senegal (SÃ©nÃ©gal)","sn","221"],["Serbia (Ð¡Ñ€Ð±Ð¸Ñ˜Ð°)","rs","381"],["Seychelles","sc","248"],["Sierra Leone","sl","232"],["Singapore","sg","65"],["Sint Maarten","sx","1721"],["Slovakia (Slovensko)","sk","421"],["Slovenia (Slovenija)","si","386"],["Solomon Islands","sb","677"],["Somalia (Soomaaliya)","so","252"],["South Africa","za","27"],["South Korea (ëŒ€í•œë¯¼êµ­)","kr","82"],["South Sudan (â€«Ø¬Ù†ÙˆØ¨ Ø§Ù„Ø³ÙˆØ¯Ø§Ù†â€¬â€Ž)","ss","211"],["Spain (EspaÃ±a)","es","34"],["Sri Lanka (à·à·Šâ€à¶»à·“ à¶½à¶‚à¶šà·à·€)","lk","94"],["Sudan (â€«Ø§Ù„Ø³ÙˆØ¯Ø§Ù†â€¬â€Ž)","sd","249"],["Suriname","sr","597"],["Svalbard and Jan Mayen","sj","47",1],["Swaziland","sz","268"],["Sweden (Sverige)","se","46"],["Switzerland (Schweiz)","ch","41"],["Syria (â€«Ø³ÙˆØ±ÙŠØ§â€¬â€Ž)","sy","963"],["Taiwan (å°ç£)","tw","886"],["Tajikistan","tj","992"],["Tanzania","tz","255"],["Thailand (à¹„à¸—à¸¢)","th","66"],["Timor-Leste","tl","670"],["Togo","tg","228"],["Tokelau","tk","690"],["Tonga","to","676"],["Trinidad and Tobago","tt","1868"],["Tunisia (â€«ØªÙˆÙ†Ø³â€¬â€Ž)","tn","216"],["Turkey (TÃ¼rkiye)","tr","90"],["Turkmenistan","tm","993"],["Turks and Caicos Islands","tc","1649"],["Tuvalu","tv","688"],["U.S. Virgin Islands","vi","1340"],["Uganda","ug","256"],["Ukraine (Ð£ÐºÑ€Ð°Ñ—Ð½Ð°)","ua","380"],["United Arab Emirates (â€«Ø§Ù„Ø¥Ù…Ø§Ø±Ø§Øª Ø§Ù„Ø¹Ø±Ø¨ÙŠØ© Ø§Ù„Ù…ØªØ­Ø¯Ø©â€¬â€Ž)","ae","971"],["United Kingdom","gb","44",0],["United States","us","1",0],["Uruguay","uy","598"],["Uzbekistan (OÊ»zbekiston)","uz","998"],["Vanuatu","vu","678"],["Vatican City (CittÃ  del Vaticano)","va","39",1],["Venezuela","ve","58"],["Vietnam (Viá»‡t Nam)","vn","84"],["Wallis and Futuna","wf","681"],["Western Sahara (â€«Ø§Ù„ØµØ­Ø±Ø§Ø¡ Ø§Ù„ØºØ±Ø¨ÙŠØ©â€¬â€Ž)","eh","212",1],["Yemen (اليمن‬‎)","ye","967"],["Zambia","zm","260"],["Zimbabwe","zw","263"],["Ã…land Islands","ax","358",1]],k=0;k<j.length;k++){var l=j[k];j[k]={name:l[0],iso2:l[1],dialCode:l[2],priority:l[3]||0,areaCodes:l[4]||null}}});