<div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="fas fa-box-open"></i> Item Management</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#item-modal" id="btn-add-item">
                <i class="fas fa-plus"></i> Add New Item
            </button>
        </div>
        
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="item-table-body">
                </tbody>
        </table>
    </div>

    <div class="modal fade" id="item-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="item-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="item-modal-title">Add Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="item_id" name="item_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Item Code</label>
                                <input type="text" class="form-control" id="item_code" name="item_code" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="item_name" name="item_name" required>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label class="form-label">Item Category</label>
                                <select class="form-select" id="category-select" name="category_id" >
                                    <option value="">Loading...</option>
                                </select>
                            </div>
                             <div class="col-md-6 mb-3">
                                <label class="form-label">Item Sub Category</label>
                                <select class="form-select" id="sub-category-select" name="sub_category_id" >
                                    <option value="">Select category first...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity (Stock)</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Unit Price</label>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

 <script defer src="assets/js/ajax/item.js"></script>
