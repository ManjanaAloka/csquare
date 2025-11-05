<div class="container my-4">
    <h2><i class="fas fa-chart-line"></i> System Reports</h2>

    <ul class="nav nav-tabs mt-3" id="reportTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="invoice-tab" data-bs-toggle="tab" data-bs-target="#invoice-report" type="button">Invoice Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="invoice-item-tab" data-bs-toggle="tab" data-bs-target="#invoice-item-report" type="button">Invoice Item Report</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="item-stock-tab" data-bs-toggle="tab" data-bs-target="#item-stock-report" type="button">Item Report</button>
        </li>
    </ul>

    <div class="tab-content pt-3" id="reportTabContent">

        <div class="tab-pane fade show active" id="invoice-report">
            <form id="form-invoice-report" class="row g-3 align-items-end p-3 mb-3 bg-light rounded border">
                <div class="col-md-5">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="invoice-start-date" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" id="invoice-end-date" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Search</button>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Customer District</th>
                        <th>Item Count</th>
                        <th>Invoice Amount</th>
                    </tr>
                </thead>
                <tbody id="invoice-report-body"></tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="invoice-item-report">
            <form id="form-invoice-item-report" class="row g-3 align-items-end p-3 mb-3 bg-light rounded border">
                <div class="col-md-5">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="invoice-item-start-date" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" id="invoice-item-end-date" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Search</button>
                </div>
            </form>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice Number</th>
                        <th>Invoiced Date</th>
                        <th>Customer Name</th>
                        <th>Item (Code)</th>
                        <th>Item Category</th>
                        <th>Item Unit Price</th>
                    </tr>
                </thead>
                <tbody id="invoice-item-report-body"></tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="item-stock-report">
            <button class="btn btn-primary mb-3" id="btn-generate-item-report">
                <i class="fas fa-sync"></i> Generate Item Stock Report
            </button>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Item Name</th>
                        <th>Item Category</th>
                        <th>Item Sub Category</th>
                        <th>Item Quantity (Stock)</th>
                    </tr>
                </thead>
                <tbody id="item-report-body"></tbody>
            </table>
        </div>
    </div>
</div>

 <script defer src="assets/js/ajax/report.js"></script>
