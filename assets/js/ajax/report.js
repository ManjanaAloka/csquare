$(document).ready(function() {

    const API_URL = 'controllers/report.php';

    // --- Helper function to format date ---
    function formatDate(dateString) {
        var date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }

    // --- REPORT A: Invoice Report ---
    $('#form-invoice-report').submit(function(e) {
        e.preventDefault();
        var startDate = $('#invoice-start-date').val();
        var endDate = $('#invoice-end-date').val();

        $('#invoice-report-body').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

        $.ajax({
            type: 'GET',
            url: API_URL,
            data: {
                action: 'report_invoice',
                start_date: startDate,
                end_date: endDate
            },
            dataType: 'json',
            success: function(response) {
                let rows = '';
                if (response.success && response.data.length > 0) {
                    response.data.forEach(row => {
                        rows += `
                            <tr>
                                <td>${row.invoice_number}</td>
                                <td>${formatDate(row.invoice_date)}</td>
                                <td>${row.customer_name}</td>
                                <td>${row.district_name}</td>
                                <td>${row.item_count}</td>
                                <td>${parseFloat(row.total_amount).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="6" class="text-center">No data found for this date range.</td></tr>';
                }
                $('#invoice-report-body').html(rows);
                console.log(response);
            }
        });
    });

    // --- REPORT B: Invoice Item Report ---
    $('#form-invoice-item-report').submit(function(e) {
        e.preventDefault();
        var startDate = $('#invoice-item-start-date').val();
        var endDate = $('#invoice-item-end-date').val();

        $('#invoice-item-report-body').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

        $.ajax({
            type: 'GET',
            url: API_URL,
            data: {
                action: 'report_invoice_item',
                start_date: startDate,
                end_date: endDate
            },
            dataType: 'json',
            success: function(response) {
                let rows = '';
                if (response.success && response.data.length > 0) {
                    response.data.forEach(row => {
                        rows += `
                            <tr>
                                <td>${row.invoice_number}</td>
                                <td>${formatDate(row.invoice_date)}</td>
                                <td>${row.customer_name}</td>
                                <td>${row.item_name} (${row.item_code})</td>
                                <td>${row.category_name}</td>
                                <td>${parseFloat(row.item_unit_price).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="6" class="text-center">No data found for this date range.</td></tr>';
                }
                $('#invoice-item-report-body').html(rows);
            }
        });
    });

    // --- REPORT C: Item (Stock) Report ---
    function loadItemReport() {
        $('#item-report-body').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

        $.ajax({
            type: 'GET',
            url: API_URL,
            data: { action: 'report_item' },
            dataType: 'json',
            success: function(response) {
                let rows = '';
                if (response.success && response.data.length > 0) {
                    response.data.forEach(row => {
                        rows += `
                            <tr>
                                <td>${row.item_name}</td>
                                <td>${row.category_name}</td>
                                <td>${row.sub_category_name}</td>
                                <td>${row.quantity}</td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="4" class="text-center">No items found.</td></tr>';
                }
                $('#item-report-body').html(rows);
            }
        });
    }

    // Button click to generate item report
    $('#btn-generate-item-report').click(loadItemReport);

    // Also load it when the tab is shown for the first time
    $('#item-stock-tab').on('shown.bs.tab', function(e) {
        if ($('#item-report-body').is(':empty')) {
            loadItemReport();
        }
    });

});