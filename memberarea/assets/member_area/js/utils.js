$.fn.select2x = function (params) { 
	try {
		let context = this;

		params.xhr = Object.assign({}, {
			url: '',
			type: 'POST',
			dataType: 'json',
			processData: true,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			data: {},
		}, params.xhr);

		if(typeof params.xhr.onStart=='function') {
			params.xhr.onStart.apply(context);
		}

		$.ajax(params.xhr)
		.done(function(response, textStatus, jqXHR) {
			if(typeof params.xhr.onSuccess=="function") {
				params.xhr.onSuccess.apply(context, [response, textStatus, jqXHR]);
			}
			
			let data = response[params.xhr.dataSrc];
			if(typeof params.placeholder == 'string') data = [{id: "0", text: params.placeholder}].concat(response[params.xhr.dataSrc]);
			params.data = data;
			$(context).empty().select2(params);
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			if(typeof params.xhr.onFail=='function') {
				params.xhr.onFail.apply(context, [jqXHR, textStatus, errorThrown]);
			}
		})
		.always(function() {
			if(typeof params.xhr.onComplete=='function') {
				params.xhr.onComplete.apply(context);
			}
		});
	} catch (error) {
		console.log(error);
	}

	return this;
}

function idDateFormat(data) {
	return moment(data).format('DD/MM/YYYY');
}

function unixDateFormat(data) {
	return moment(data, "X").format('DD/MM/YYYY');
}

function idDateTimeFormat(data) {
	return moment(data).format('DD/MM/YYYY HH:mm:ss');
}

function unixDateTimeFormat(data) {
	return moment(data, "X").format('DD/MM/YYYY HH:mm:ss');
}

function idr(angka, prefix="") { 
	const format = Intl.NumberFormat().format(angka).replaceAll(',', '.');
	if(prefix.length>0) {
		return `${prefix} ${format}`;
	} else {
		return format;
	}
}

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix=""){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}

	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
}

$("input[data-type='number']").keyup(function(event){
    if(event.which >= 37 && event.which <= 40){
        event.preventDefault();
    }
    var $this = $(this);
    var text = $this.val().replace(/[^0-9\.]/g, "");
    var num = text.replace(/\./gi, "");
    var num2 = num.split(/(?=(?:\d{3})+$)/).join(".");
    $this.val(num2);
});

$.fn.readmore = function(len=125) {
    string = this.text();
    if(string) {
        if(string.length > len) {
            var text_view = `<span>${string.substring(0, len)}<a read="more" href="#" type="button">.. (Baca Selengkapnya)</a></span>`;
            var text_more = `<span class="more">${string.substring(len, string.length)} <a read="less" href="#" type="button">(Lebih Sedikit)</a></span>`
            var p = '<p read="less">' + text_view + text_more + '<p>';
            this.html(p);
        } else {
            return string;
        }
    }
    
    
    $('a[read="more"]', this).click(function (e) {
        e.preventDefault();
        this.closest('p[read]').setAttribute('read', 'more');
    });

    $('a[read="less"]', this).click(function (e) {
        e.preventDefault();
        this.closest('p[read]').setAttribute('read', 'less');
    });
    
    return this;
}

String.prototype.toHTML = function () {
	const parser = new DOMParser();
	let html = parser.parseFromString(this, 'text/html');
	return html.body.firstChild;
}

HTMLElement.prototype.appendHTML = function (strHtml, register="", ev=false) {
	const parser = new DOMParser();
	let html = parser.parseFromString(strHtml, 'text/html');
	let child = html.body.firstChild;
	if(register.length>0 && typeof ev == 'function' ) {
		child[register] = ev;
	}
	this.append(child);
}

const unix_start = moment('1970-01-01 00:00:00');
const unix_finish = moment().endOf('day');
const drpConfig = {
	autoApply: true,
	locale: {
		format: 'DD-MM-YYYY',
		separator: '/'
	},
	opens: 'left',
	startDate: unix_start,
	endDate: unix_finish,
	ranges: {
		'Hari Ini': [moment(), unix_finish],
		'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Seminggu Lalu': [moment().subtract(6, 'days'), moment()],
		'1 Bulan Terkahir': [moment().subtract(29, 'days'), moment()],
		'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
		'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		'Semua': [unix_start, unix_finish]
	}
}