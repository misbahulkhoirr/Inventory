'use strict';
$(document).ready(function() {
    $(function() {
	  $('input[name="daterange"]').daterangepicker({
		opens: 'left'
	  }, function(start, end, label) {
		
	  });
	});
	$(function() {
	  $('input[name="datetimes"]').daterangepicker({
		timePicker: true,
		startDate: moment().startOf('hour'),
		endDate: moment().startOf('hour').add(32, 'hour'),
		locale: {
		  format: 'M/DD hh:mm A'
		}
	  });
	});
	$(function() {
	  $('input[name="birthday"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		minYear: 1901,
		maxYear: parseInt(moment().format('YYYY'),10)
	  }, function(start, end, label) {
		var years = moment().diff(start, 'years');
		alert("You are " + years + " years old!");
	  });
	});
	$(function() {

		var start = moment().subtract(29, 'days');
		var end = moment();
		// console.log('cookie = ' + getCookie('start'));
		start = moment(getCookie('start'))
		end = moment(getCookie('end'))
		function cb(start, end) {
			// console.log('start = ' + start.format('YYYY-MM-DD'));
			$('#from').val(start.format('YYYY-MM-DD'));
			$('#to').val(end.format('YYYY-MM-DD'));
			$('#from2').val(start.format('YYYY-MM-DD'));
			$('#to2').val(end.format('YYYY-MM-DD'));
			$('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
			$('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
		}

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
			   'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, cb);
		function getCookie(cName) {
			const name = cName + "=";
			const cDecoded = decodeURIComponent(document.cookie); //to be careful
			const cArr = cDecoded .split('; ');
			let res;
			cArr.forEach(val => {
				if (val.indexOf(name) === 0) res = val.substring(name.length);
			})
			return res;
	  	}
		cb(start, end);

	});
	$(function() {
	  $('input[name="datefilter"]').daterangepicker({
		  autoUpdateInput: false,
		  locale: {
			  cancelLabel: 'Clear'
		  }
	  });

	  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	  });

	  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
	  });

	});
});