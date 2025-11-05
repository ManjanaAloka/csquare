$(document).ready(function() {
    const API_URL = 'controllers/item.php';

    // Get modal instance
    var itemModalEl = document.getElementById('item-modal');
    var itemModal = bootstrap.Modal.getInstance(itemModalEl);
    if (!itemModal) {
        itemModal = new bootstrap.Modal(itemModalEl);
    }

    // --- READ: Load all items ---
    function loadItems() {
        $('#item-table-body').html('<tr><td colspan="7" class="text-center">Loading...</td></tr>');

        $.ajax({
            type: 'GET',
            url: API_URL,
            data: { action: 'get_items' },
            dataType: 'json',
            success: function(response) {
                let rows = '';
                if (response.success && response.data.length > 0) {
                    response.data.forEach(item => {
                        rows += `
                            <tr>
                                <td>${item.item_code}</td>
                                <td>${item.item_name}</td>
                                <td>${item.category_name}</td>
                                <td>${item.sub_category_name}</td>
                                <td>${item.quantity}</td>
                                <td>${parseFloat(item.unit_price).toFixed(2)}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-edit" data-id="${item.item_id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" data-id="${item.item_id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="7" class="text-center">No items found.</td></tr>';
                }
                $('#item-table-body').html(rows);
            }
        });
    }

    // --- READ: Load categories for dropdown ---
    function loadCategories() {
        $.ajax({
            type: 'GET',
            url: API_URL,
            data: { action: 'get_categories' },
            dataType: 'json',
            success: function(response) {
                let options = '<option value="">Select category...</option>';
                if (response.success) {
                    response.data.forEach(cat => {
                        options += `<option value="${cat.category_id}">${cat.category_name}</option>`;
                    });
                }
                $('#category-select').html(options);
            }
        });
    }

    // --- READ: Load sub-categories when category changes ---
    $('#category-select').change(function() {
        var category_id = $(this).val();
        if (category_id) {
            $.ajax({
                type: 'GET',
                url: API_URL,
                data: { action: 'get_sub_categories', category_id: category_id },
                dataType: 'json',
                success: function(response) {
                    let options = '<option value="">Select sub category...</option>';
                    if (response.success) {
                        response.data.forEach(subcat => {
                            options += `<option value="${subcat.sub_category_id}">${subcat.sub_category_name}</option>`;
                        });
                    }
                    $('#sub-category-select').html(options);
                }
            });
        } else {
            $('#sub-category-select').html('<option value="">Select category first...</option>');
        }
    });


    // --- CREATE / UPDATE: Handle form submission ---
    $('#item-form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize() + '&action=save_item';

        $.ajax({
            type: 'POST',
            url: API_URL,
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    itemModal.hide();
                    loadItems();
                } else {
                    alert('Error: ' + response.message);
                }
            }
        });
    });

    // --- Prep for CREATE ---
    $('#btn-add-item').click(function() {
        $('#item-form')[0].reset();
        $('#item_id').val('');
        $('#item-modal-title').text('Add Item');
        $('#sub-category-select').html('<option value="">Select category first...</option>');
    });

    // --- Prep for UPDATE ---
    $('#item-table-body').on('click', '.btn-edit', function() {
        var id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: API_URL,
            data: { action: 'get_item', id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var item = response.data;

                    // Fill basic fields
                    $('#item_id').val(item.item_id);
                    $('#item_code').val(item.item_code);
                    $('#item_name').val(item.item_name);
                    $('#quantity').val(item.quantity);
                    $('#unit_price').val(item.unit_price);

                    // Load categories and set the correct one
                    $('#category-select').val(item.category_id);

                    // Load sub-categories for the selected category
                    // We need to do this *before* setting the sub-category value
                    $.ajax({
                        type: 'GET',
                        url: API_URL,
                        data: { action: 'get_sub_categories', category_id: item.category_id },
                        dataType: 'json',
                        success: function(subResponse) {
                            let options = '<option value="">Select sub category...</option>';
                            if (subResponse.success) {
                                subResponse.data.forEach(subcat => {
                                    options += `<option value="${subcat.sub_category_id}">${subcat.sub_category_name}</option>`;
                                });
                            }
                            $('#sub-category-select').html(options);
                            // NOW set the sub-category value
                            $('#sub-category-select').val(item.sub_category_id);
                        }
                    });

                    $('#item-modal-title').text('Edit Item');
                    itemModal.show();
                }
            }
        });
    });

    // --- DELETE ---
    $('#item-table-body').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                type: 'POST',
                url: API_URL,
                data: { action: 'delete_item', id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        loadItems();
                    } else {
                        alert('Error: ' + response.message);
                    }
                }
            });
        }
    });

    // --- Initial Load ---
    loadItems();
    loadCategories();

});