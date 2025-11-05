$(document).ready(function() {

    // The PHP file that handles all requests
    const API_URL = 'controllers/customer.php';

    // Get the Bootstrap modal instance
    var customerModal = new bootstrap.Modal(document.getElementById('customer-modal'));

    // --- READ: Load all customers on page load ---
    function loadCustomers() {
        // Show a loading message
        $('#customer-table-body').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

        // ** AJAX REQUEST **
        $.ajax({
            type: 'GET',
            url: API_URL,
            data: { action: 'get_customers' }, // Tell PHP what we want
            dataType: 'json',
            success: function(response) {
                let rows = '';
                if (response.success && response.data.length > 0) {
                    // Loop over each customer
                    response.data.forEach(customer => {
                        rows += `
                            <tr>
                                <td>${customer.title} ${customer.first_name} ${customer.last_name}</td>
                                <td>${customer.contact_number}</td>
                                <td>${customer.district_name}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-id="${customer.customer_id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="${customer.customer_id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="4" class="text-center">No customers found.</td></tr>';
                }
                // Put the new HTML rows into the table body
                $('#customer-table-body').html(rows);
            },
            error: function() {
                alert('Error loading customers.');
            }
        });
    }

    // --- READ: Load districts for the dropdown ---
    function loadDistricts() {
        $.ajax({
            type: 'GET',
            url: API_URL,
            data: { action: 'get_districts' },
            dataType: 'json',
            success: function(response) {
                let options = '<option value="">Select district...</option>';
                if (response.success) {
                    response.data.forEach(district => {
                        options += `<option value="${district.district_id}">${district.district_name}</option>`;
                    });
                }
                $('#district-select').html(options); // Fill the dropdown
            }
        });
    }

    // --- CREATE / UPDATE: Handle form submission ---
    $('#customer-form').submit(function(e) {
        e.preventDefault(); // Stop the form from submitting normally

        // Get all form data
        var formData = $(this).serialize();
        // Add the action to the form data
        formData += '&action=save_customer';

        // ** AJAX REQUEST **
        $.ajax({
            type: 'POST',
            url: API_URL,
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message); // Show success message
                    customerModal.hide(); // Hide the modal
                    loadCustomers(); // Refresh the customer list
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error saving customer.');
            }
        });
    });

    // --- Prep for CREATE: Clear modal when "Add New" is clicked ---
    $('#btn-add-customer').click(function() {
        $('#customer-form')[0].reset(); // Reset form fields
        $('#customer_id').val(''); // Clear hidden ID
        $('#customer-modal-title').text('Add Customer'); // Set title
    });

    // --- Prep for UPDATE: Load customer data into modal ---
    // Use '.on()' for buttons that are loaded by AJAX
    $('#customer-table-body').on('click', '.btn-edit', function() {
        var id = $(this).data('id'); // Get the ID from the data-id attribute

        // ** AJAX REQUEST **
        $.ajax({
            type: 'GET',
            url: API_URL,
            data: { action: 'get_customer', id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var customer = response.data;
                    // Fill the form fields
                    $('#customer_id').val(customer.customer_id); // This is the hidden ID
                    $('#title').val(customer.title);
                    $('#first_name').val(customer.first_name);
                    $('#last_name').val(customer.last_name);
                    $('#contact_number').val(customer.contact_number);
                    $('#district-select').val(customer.district_id);

                    $('#customer-modal-title').text('Edit Customer'); // Set title
                    customerModal.show(); // Show the modal
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    });

    // --- DELETE: Handle delete button click ---
    $('#customer-table-body').on('click', '.btn-delete', function() {
        var id = $(this).data('id');

        if (confirm('Are you sure you want to delete this customer?')) {
            // ** AJAX REQUEST **
            $.ajax({
                type: 'POST',
                url: API_URL,
                data: { action: 'delete_customer', id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        loadCustomers(); // Refresh the list
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            });
        }
    });

    // --- Initial Page Load ---
    loadCustomers();
    loadDistricts();

});