//  This file is part of the jQuery formatCurrency Plugin.
//
//    The jQuery formatCurrency Plugin is free software: you can redistribute it
//    and/or modify it under the terms of the GNU General Public License as published 
//    by the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.

//    The jQuery formatCurrency Plugin is distributed in the hope that it will
//    be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
//    of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License along with 
//    the jQuery formatCurrency Plugin.  If not, see <http://www.gnu.org/licenses/>.

(function($) {

	$.formatCurrency = {};

	$.formatCurrency.regions = [];

	// default Region is en
	$.formatCurrency.regions[''] = {
		symbol: '$',
		positiveFormat: '%s%n',
		negativeFormat: '(%s%n)',
		decimalSymbol: '.',
		digitGroupSymbol: ',',
		groupDigits: true
	};

	$.fn.formatCurrency = function(destination, settings) {

		if (arguments.length == 1 && typeof destination !== "string") {
			settings = destination;
			destination = false;
		}

		// initialize defaults
		var defaults = {
			name: "formatCurrency",
			colorize: false,
			region: '',
			global: true,
			roundToDecimalPlace: 2, // roundToDecimalPlace: -1; for no rounding; 0 to round to the dollar; 1 for one digit cents; 2 for two digit cents; 3 for three digit cents; ...
			eventOnDecimalsEntered: false
		};
		// initialize default region
		defaults = $.extend(defaults, $.formatCurrency.regions['']);
		// override defaults with settings passed in
		settings = $.extend(defaults, settings);

		// check for region setting
		if (settings.region.length > 0) {
			settings = $.extend(settings, getRegionOrCulture(settings.region));
		}
		settings.regex = generateRegex(settings);

		return this.each(function() {
			$this = $(this);

			// get number
			var num = '0';
			num = $this[$this.is('input, select, textarea') ? 'val' : 'html']();

			//identify '(123)' as a negative number
			if (num.search('\\(') >= 0) {
				num = '-' + num;
			}

			if (num === '' || (num === '-' && settings.roundToDecimalPlace === -1)) {
				return;
			}

			// if the number is valid use it, otherwise clean it
			if (isNaN(num)) {
				// clean number
				num = num.replace(settings.regex, '');
				
				if (num === '' || (num === '-' && settings.roundToDecimalPlace === -1)) {
					return;
				}
				
				if (settings.decimalSymbol != '.') {
					num = num.replace(settings.decimalSymbol, '.');  // reset to US decimal for arithmetic
				}
				if (isNaN(num)) {
					num = '0';
				}
			}
			
			// evalutate number input
			var numParts = String(num).split('.');
			var isPositive = (num == Math.abs(num));
			var hasDecimals = (numParts.length > 1);
			var decimals = (hasDecimals ? numParts[1].toString() : '0');
			var originalDecimals = decimals;
			
			// format number
			num = Math.abs(numParts[0]);
			num = isNaN(num) ? 0 : num;
			if (settings.roundToDecimalPlace >= 0) {
				decimals = parseFloat('1.' + decimals); // prepend "0."; (IE does NOT round 0.50.toFixed(0) up, but (1+0.50).toFixed(0)-1
				decimals = decimals.toFixed(settings.roundToDecimalPlace); // round
				if (decimals.substring(0, 1) == '2') {
					num = Number(num) + 1;
				}
				decimals = decimals.substring(2); // remove "0."
			}
			num = String(num);

			if (settings.groupDigits) {
				for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
					num = num.substring(0, num.length - (4 * i + 3)) + settings.digitGroupSymbol + num.substring(num.length - (4 * i + 3));
				}
			}

			if ((hasDecimals && settings.roundToDecimalPlace == -1) || settings.roundToDecimalPlace > 0) {
				num += settings.decimalSymbol + decimals;
			}

			// format symbol/negative
			var format = isPositive ? settings.positiveFormat : settings.negativeFormat;
			var money = format.replace(/%s/g, settings.symbol);
			money = money.replace(/%n/g, num);

			// setup destination
			var $destination = $([]);
			if (!destination) {
				$destination = $this;
			} else {
				$destination = $(destination);
			}
			// set destination
			$destination[$destination.is('input, select, textarea') ? 'val' : 'html'](money);

			if (
				hasDecimals && 
				settings.eventOnDecimalsEntered && 
				originalDecimals.length > settings.roundToDecimalPlace
			) {
				$destination.trigger('decimalsEntered', originalDecimals);
			}

			// colorize
			if (settings.colorize) {
				$destination.css('color', isPositive ? 'black' : 'red');
			}
		});
	};

	// Remove all non numbers from text
	$.fn.toNumber = function(settings) {
		var defaults = $.extend({
			name: "toNumber",
			region: '',
			global: true
		}, $.formatCurrency.regions['']);

		settings = jQuery.extend(defaults, settings);
		if (settings.region.length > 0) {
			settings = $.extend(settings, getRegionOrCulture(settings.region));
		}
		settings.regex = generateRegex(settings);

		return this.each(function() {
			var method = $(this).is('input, select, textarea') ? 'val' : 'html';
			$(this)[method]($(this)[method]().replace('(', '(-').replace(settings.regex, ''));
		});
	};

	// returns the value from the first element as a number
	$.fn.asNumber = function(settings) {
		var defaults = $.extend({
			name: "asNumber",
			region: '',
			parse: true,
			parseType: 'Float',
			global: true
		}, $.formatCurrency.regions['']);
		settings = jQuery.extend(defaults, settings);
		if (settings.region.length > 0) {
			settings = $.extend(settings, getRegionOrCulture(settings.region));
		}
		settings.regex = generateRegex(settings);
		settings.parseType = validateParseType(settings.parseType);

		var method = $(this).is('input, select, textarea') ? 'val' : 'html';
		var num = $(this)[method]();
		num = num ? num : "";
		num = num.replace('(', '(-');
		num = num.replace(settings.regex, '');
		if (!settings.parse) {
			return num;
		}

		if (num.length == 0) {
			num = '0';
		}

		if (settings.decimalSymbol != '.') {
			num = num.replace(settings.decimalSymbol, '.');  // reset to US decimal for arthmetic
		}

		return window['parse' + settings.parseType](num);
	};

	function getRegionOrCulture(region) {
		var regionInfo = $.formatCurrency.regions[region];
		if (regionInfo) {
			return regionInfo;
		}
		else {
			if (/(\w+)-(\w+)/g.test(region)) {
				var culture = region.replace(/(\w+)-(\w+)/g, "$1");
				return $.formatCurrency.regions[culture];
			}
		}
		// fallback to extend(null) (i.e. nothing)
		return null;
	}

	function validateParseType(parseType) {
		switch (parseType.toLowerCase()) {
			case 'int':
				return 'Int';
			case 'float':
				return 'Float';
			default:
				throw 'invalid parseType';
		}
	}
	
	function generateRegex(settings) {
		if (settings.symbol === '') {
			return new RegExp("[^\\d" + settings.decimalSymbol + "-]", "g");
		}
		else {
			var symbol = settings.symbol.replace('$', '\\$').replace('.', '\\.');		
			return new RegExp(symbol + "|[^\\d" + settings.decimalSymbol + "-]", "g");
		}	
	}

})(jQuery);

//  This file is part of the jQuery formatCurrency Plugin.
//
//    The jQuery formatCurrency Plugin is free software: you can redistribute it
//    and/or modify it under the terms of the GNU General Public License as published 
//    by the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.

//    The jQuery formatCurrency Plugin is distributed in the hope that it will
//    be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
//    of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License along with 
//    the jQuery formatCurrency Plugin.  If not, see <http://www.gnu.org/licenses/>.

!function(o){o.formatCurrency.regions["af-ZA"]={symbol:"R",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["am-ET"]={symbol:"ETB",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-AE"]={symbol:"د.إ.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-BH"]={symbol:"د.ب.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-DZ"]={symbol:"د.ج.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-EG"]={symbol:"ج.م.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-IQ"]={symbol:"د.ع.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-JO"]={symbol:"د.ا.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-KW"]={symbol:"د.ك.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-LB"]={symbol:"ل.ل.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-LY"]={symbol:"د.ل.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-MA"]={symbol:"د.م.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-OM"]={symbol:"ر.ع.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-QA"]={symbol:"ر.ق.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-SA"]={symbol:"ر.س.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-SY"]={symbol:"ل.س.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-TN"]={symbol:"د.ت.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ar-YE"]={symbol:"ر.ي.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["arn-CL"]={symbol:"$",positiveFormat:"%s %n",negativeFormat:"-%s %n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["as-IN"]={symbol:"ট",positiveFormat:"%n%s",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["az-Cyrl-AZ"]={symbol:"ман.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["az-Latn-AZ"]={symbol:"man.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["ba-RU"]={symbol:"һ.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["be-BY"]={symbol:"р.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["bg-BG"]={symbol:"лв",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["bn-BD"]={symbol:"৳",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["bn-IN"]={symbol:"টা",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["bo-CN"]={symbol:"¥",positiveFormat:"%s%n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["br-FR"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["bs-Cyrl-BA"]={symbol:"КМ",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["bs-Latn-BA"]={symbol:"KM",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["ca-ES"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["co-FR"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["cs-CZ"]={symbol:"Kč",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["cy-GB"]={symbol:"£",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["da-DK"]={symbol:"kr",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["de-AT"]={symbol:"€",positiveFormat:"%s %n",negativeFormat:"-%s %n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["de-CH"]={symbol:"SFr.",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:"'",groupDigits:!0},o.formatCurrency.regions["de-DE"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["de-LI"]={symbol:"CHF",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:"'",groupDigits:!0},o.formatCurrency.regions["de-LU"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions.de={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["dsb-DE"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["dv-MV"]={symbol:"ރ.",positiveFormat:"%n %s",negativeFormat:"%n %s-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["el-GR"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["en-029"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-AU"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-BZ"]={symbol:"BZ$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-CA"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-GB"]={symbol:"£",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-IE"]={symbol:"€",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-IN"]={symbol:"Rs.",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-JM"]={symbol:"J$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-MY"]={symbol:"RM",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-NZ"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-PH"]={symbol:"Php",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-SG"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-TT"]={symbol:"TT$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-US"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-ZA"]={symbol:"R",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["en-ZW"]={symbol:"Z$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-AR"]={symbol:"$",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-BO"]={symbol:"$b",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-CL"]={symbol:"$",positiveFormat:"%s %n",negativeFormat:"-%s %n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-CO"]={symbol:"$",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-CR"]={symbol:"₡",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-DO"]={symbol:"RD$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-EC"]={symbol:"$",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-ES"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-GT"]={symbol:"Q",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-HN"]={symbol:"L.",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-MX"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-NI"]={symbol:"C$",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-PA"]={symbol:"B/.",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-PE"]={symbol:"S/.",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-PR"]={symbol:"$",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-PY"]={symbol:"Gs",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-SV"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-US"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["es-UY"]={symbol:"$U",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["es-VE"]={symbol:"Bs",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions.es={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["et-EE"]={symbol:"kr",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:".",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["eu-ES"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["fa-IR"]={symbol:"ريال",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:"/",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["fi-FI"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["fil-PH"]={symbol:"PhP",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["fo-FO"]={symbol:"kr",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["fr-BE"]={symbol:"€",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["fr-CA"]={symbol:"$",positiveFormat:"%n %s",negativeFormat:"(%n %s)",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["fr-CH"]={symbol:"SFr.",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:"'",groupDigits:!0},o.formatCurrency.regions["fr-FR"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["fr-LU"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["fr-MC"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions.fr={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["fy-NL"]={symbol:"€",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["ga-IE"]={symbol:"€",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["gl-ES"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["gsw-FR"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["gu-IN"]={symbol:"રૂ",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ha-Latn-NG"]={symbol:"N",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["he-IL"]={symbol:"₪",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["hi-IN"]={symbol:"रु",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["hr-BA"]={symbol:"KM",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["hr-HR"]={symbol:"kn",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["hsb-DE"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["hu-HU"]={symbol:"Ft",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["hy-AM"]={symbol:"դր.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["id-ID"]={symbol:"Rp",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["ig-NG"]={symbol:"N",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ii-CN"]={symbol:"¥",positiveFormat:"%s%n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["is-IS"]={symbol:"kr.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["it-CH"]={symbol:"SFr.",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:"'",groupDigits:!0},o.formatCurrency.regions["it-IT"]={symbol:"€",positiveFormat:"%s %n",negativeFormat:"-%s %n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions.it={symbol:"€",positiveFormat:"%s %n",negativeFormat:"-%s %n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["iu-Cans-CA"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["iu-Latn-CA"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ja-JP"]={symbol:"¥",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions.ja={symbol:"¥",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ka-GE"]={symbol:"Lari",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["kk-KZ"]={symbol:"Т",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:"-",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["kl-GL"]={symbol:"kr.",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["km-KH"]={symbol:"៛",positiveFormat:"%n%s",negativeFormat:"-%n%s",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["kn-IN"]={symbol:"ರೂ",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ko-KR"]={symbol:"₩",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["kok-IN"]={symbol:"रु",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ky-KG"]={symbol:"сом",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:"-",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["lb-LU"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["lo-LA"]={symbol:"₭",positiveFormat:"%n%s",negativeFormat:"(%n%s)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["lt-LT"]={symbol:"Lt",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["lv-LV"]={symbol:"Ls",positiveFormat:"%s %n",negativeFormat:"-%s %n",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["mi-NZ"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["mk-MK"]={symbol:"ден.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["ml-IN"]={symbol:"ക",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["mn-MN"]={symbol:"₮",positiveFormat:"%n%s",negativeFormat:"-%n%s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["mn-Mong-CN"]={symbol:"¥",positiveFormat:"%s%n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["moh-CA"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["mr-IN"]={symbol:"रु",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ms-BN"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["ms-MY"]={symbol:"R",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["mt-MT"]={symbol:"Lm",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["nb-NO"]={symbol:"kr",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["ne-NP"]={symbol:"रु",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["nl-BE"]={symbol:"€",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["nl-NL"]={symbol:"€",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["nn-NO"]={symbol:"kr",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["nso-ZA"]={symbol:"R",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["oc-FR"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["or-IN"]={symbol:"ଟ",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["pa-IN"]={symbol:"ਰੁ",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["pl-PL"]={symbol:"zł",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["prs-AF"]={symbol:"؋",positiveFormat:"%s%n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ps-AF"]={symbol:"؋",positiveFormat:"%s%n",negativeFormat:"%s%n-",decimalSymbol:"٫",digitGroupSymbol:"٬",groupDigits:!0},o.formatCurrency.regions["pt-BR"]={symbol:"R$",positiveFormat:"%s %n",negativeFormat:"-%s %n",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["pt-PT"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["qut-GT"]={symbol:"Q",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["quz-BO"]={symbol:"$b",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["quz-EC"]={symbol:"$",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["quz-PE"]={symbol:"S/.",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["rm-CH"]={symbol:"fr.",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:"'",groupDigits:!0},o.formatCurrency.regions["ro-RO"]={symbol:"lei",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["ru-RU"]={symbol:"р.",positiveFormat:"%n%s",negativeFormat:"-%n%s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["rw-RW"]={symbol:"RWF",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["sa-IN"]={symbol:"रु",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["sah-RU"]={symbol:"с.",positiveFormat:"%n%s",negativeFormat:"-%n%s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["se-FI"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["se-NO"]={symbol:"kr",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["se-SE"]={symbol:"kr",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["si-LK"]={symbol:"රු.",positiveFormat:"%s %n",negativeFormat:"(%s %n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["sk-SK"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["sl-SI"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["sma-NO"]={symbol:"kr",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["sma-SE"]={symbol:"kr",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["smj-NO"]={symbol:"kr",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["smj-SE"]={symbol:"kr",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["smn-FI"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["sms-FI"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["sq-AL"]={symbol:"Lek",positiveFormat:"%n%s",negativeFormat:"-%n%s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["sr-Cyrl-BA"]={symbol:"КМ",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["sr-Cyrl-CS"]={symbol:"Дин.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["sr-Latn-BA"]={symbol:"KM",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["sr-Latn-CS"]={symbol:"Din.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["sv-FI"]={symbol:"€",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["sv-SE"]={symbol:"kr",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["sw-KE"]={symbol:"S",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["syr-SY"]={symbol:"ل.س.‏",positiveFormat:"%s %n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ta-IN"]={symbol:"ரூ",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["te-IN"]={symbol:"రూ",positiveFormat:"%s %n",negativeFormat:"%s -%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["tg-Cyrl-TJ"]={symbol:"т.р.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:";",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["th-TH"]={symbol:"฿",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["tk-TM"]={symbol:"m.",positiveFormat:"%n%s",negativeFormat:"-%n%s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["tn-ZA"]={symbol:"R",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["tr-TR"]={symbol:"TL",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["tt-RU"]={symbol:"р.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["tzm-Latn-DZ"]={symbol:"DZD",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["ug-CN"]={symbol:"¥",positiveFormat:"%s%n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["uk-UA"]={symbol:"грн.",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["ur-PK"]={symbol:"Rs",positiveFormat:"%s%n",negativeFormat:"%s%n-",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["uz-Cyrl-UZ"]={symbol:"сўм",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["uz-Latn-UZ"]={symbol:"su'm",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["vi-VN"]={symbol:"₫",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:".",groupDigits:!0},o.formatCurrency.regions["wo-SN"]={symbol:"XOF",positiveFormat:"%n %s",negativeFormat:"-%n %s",decimalSymbol:",",digitGroupSymbol:" ",groupDigits:!0},o.formatCurrency.regions["xh-ZA"]={symbol:"R",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["yo-NG"]={symbol:"N",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["zh-CN"]={symbol:"￥",positiveFormat:"%s%n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["zh-HK"]={symbol:"HK$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["zh-MO"]={symbol:"MOP",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["zh-SG"]={symbol:"$",positiveFormat:"%s%n",negativeFormat:"(%s%n)",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["zh-TW"]={symbol:"NT$",positiveFormat:"%s%n",negativeFormat:"-%s%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions.zh={symbol:"¥",positiveFormat:"%s%n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0},o.formatCurrency.regions["zu-ZA"]={symbol:"R",positiveFormat:"%s %n",negativeFormat:"%s-%n",decimalSymbol:".",digitGroupSymbol:",",groupDigits:!0}}(jQuery);