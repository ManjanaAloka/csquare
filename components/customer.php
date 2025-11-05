 <div class="container my-4">
     <div class="d-flex justify-content-between align-items-center mb-3">
         <h2><i class="fas fa-users"></i> Customer Management</h2>
         <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customer-modal" id="btn-add-customer">
             <i class="fas fa-plus"></i> Add New Customer
         </button>
     </div>

     <table class="table table-striped table-hover">
         <thead class="table-dark">
             <tr>
                 <th>Name</th>
                 <th>Contact No.</th>
                 <th>District</th>
                 <th>Actions</th>
             </tr>
         </thead>
         <tbody id="customer-table-body">
         </tbody>
     </table>
 </div>

 <div class="modal fade" id="customer-modal" tabindex="-1">
     <div class="modal-dialog">
         <div class="modal-content">
             <form id="customer-form">
                 <div class="modal-header">
                     <h5 class="modal-title" id="customer-modal-title">Add Customer</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                 </div>
                 <div class="modal-body">
                     <input type="hidden" id="customer_id" name="customer_id">

                     <div class="mb-3">
                         <label class="form-label">Title</label>
                         <select class="form-select" id="title" name="title" required>
                             <option value="Mr">Mr</option>
                             <option value="Mrs">Mrs</option>
                             <option value="Miss">Miss</option>
                             <option value="Dr">Dr</option>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label class="form-label">First Name</label>
                         <input type="text" class="form-control" id="first_name" name="first_name" required>
                     </div>
                     <div class="mb-3">
                         <label class="form-label">Last Name</label>
                         <input type="text" class="form-control" id="last_name" name="last_name" required>
                     </div>
                     <div class="mb-3">
                         <label class="form-label">Contact Number</label>
                         <input type="text" class="form-control" id="contact_number" name="contact_number">
                     </div>
                     <div class="mb-3">
                         <label class="form-label">District</label>
                         <select class="form-select" id="district-select" name="district_id">
                             <option value="">Loading districts...</option>
                         </select>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Save Customer</button>
                 </div>
             </form>
         </div>
     </div>
 </div>


 <script defer src="assets/js/ajax/customer.js"></script>