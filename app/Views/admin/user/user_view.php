<div class="body-content">
  <div class="crud-text"><h1>Users</h1></div>
  <div class="d-flex justify-content-left">
    <a href="<?= base_url('user/create/view') ?>" class="btn">Add User</a>
    <a href="<?= base_url('user/print') ?>" target="_blank" class="btn">Print</a>
 </div>
 <div class="mt-3">
    <table class="table table-bordered" user_id="users-list" id="table1">
     <thead>
        <tr>
           <th>#</th>
           <th>User Name</th>
           <th>Email Address</th>
           <th>Address</th>
           <th>Contact Number</th>
           <th>Role</th>
           <!-- <th>Status</th> -->
           <th>Action</th>
        </tr>
     </thead>
     <tbody>
        <?php if($users): $n = 0;?>
           <?php foreach($users as $user):  
            if($user['name'] != $_SESSION['username'] ):
               ?>
               <tr>
                 <td><?php echo $n ?></td>
                 <td><?php echo $user['name']; ?></td>
                 <td><?php echo $user['email']; ?></td>
                 <td><?php echo $user['address']; ?></td>
                 <td><?php echo $user['contact']; ?></td>
                 <td><?php echo $user['position']; ?></td>
                 
                 <td>
                   <a href="<?php echo base_url('/user/'.$user['user_id']);?>" class="btn btn-primary btn-sm">Edit</a>
                   <a href="<?php echo base_url('/user/delete/'.$user['user_id']);?>" class="btn btn-danger btn-sm del" >Delete</a>
                   <!-- <a href="#" >Click me</a> -->
                </td>
             </tr>
          <?php endif; ?>
          <?php $n=$n+1; endforeach; ?>
       <?php endif; ?>
    </tbody>
 </table>
</div>
</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
   var msg = ''; 
   var del = '';
   var add = '';
   var update = '';
   <?php if(session()->has('msg')){?>
      msg = true;
      del = 'User is Deleted Successfully';
   <?php }elseif(session()->has('add')){?>
      add = true;
      del = 'New User is Added Successfully';
   <?php }elseif(session()->has('update')){?>
      update = true;
      del = 'User Details are Updated Successfully';
      <?php }?>;
   </script>
   <script type="text/javascript" src="<?= base_url('assets/js/crud.js')?>"></script>