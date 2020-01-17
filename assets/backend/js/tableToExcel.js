/*var tableToExcel = (function() {
	  var uri = 'data:application/vnd.ms-excel;base64,'
		, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
		, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
		, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	  return function(table, name, fileName) {
		if (!table.nodeType) table = document.getElementById(table)
		var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
		
		var link = document.createElement("A");
		link.href = uri + base64(format(template, ctx));
		link.download = fileName || 'Workbook.xls';
		link.target = '_blank';
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	  }
})();*/
function fnExcelReport($nama_file="") {
  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
  tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';

  tab_text = tab_text + '<x:Name>Sheet1</x:Name>';

  tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
  tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

  tab_text = tab_text + "<table border='1px'>";
  tab_text = tab_text + $('#table-export').html();
  tab_text = tab_text + '</table></body></html>';

  var data_type = 'data:application/vnd.ms-excel';

  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");
  var fileName = $nama_file+'.xls';
var blob = new Blob([ tab_text ], {
    type : "application/csv;charset=utf-8;"
});

if (window.navigator.msSaveBlob) {
    // FOR IE BROWSER
    navigator.msSaveBlob(blob, fileName);
} else {
    // FOR OTHER BROWSERS
    var csvUrl = URL.createObjectURL(blob);
    $('#exportExcel').attr({
        'download': fileName,
        'href': csvUrl
    });
}
  /*if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    if (window.navigator.msSaveBlob) {
      var blob = new Blob([tab_text], {
        type: "application/csv;charset=utf-8;"
      });
      navigator.msSaveBlob(blob, 'Test file.xls');
    }
  } else {
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    $('#test').attr('download', 'Test file.xls');
  }*/

}
