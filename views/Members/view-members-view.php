
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Members</title>
  
    <link rel="stylesheet" href="../../styles/bulma.min.css">
    <link rel="stylesheet" href="../../styles/sweetalert2.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script type="text/javascript" src="../../scripts/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../../scripts/jquery.min.js"></script>
    <script type="text/javascript" src="../../scripts/datatables.min.js"></script>
    <script type="text/javascript" src="../../scripts/views/app/view-members.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/datatables-bulma@1.0.1/js/dataTables.bulma.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables-bulma@1.0.1/css/dataTables.bulma.min.css">
    
    <link rel="stylesheet" href="../../styles/datatables.min.css">
  </head>
  
  <body>
  <?php include_once '../Shared/header.php';?>

    <section class="section">
      <div class="container">
        <h1 class="title"> See your members. </h1> 
      </div>
    </section>

    <section class="section">
      <div class="container">
         <table class ="table is-hoverable is-striped" style="width:100%" id="tblMembers">
            <thead>
              <tr>
              <th>Id</th>
              <th>Title</th>
              <th>Contact Name</th>
              <th>Full Name</th>
              <th>Mobile</th>
              <th>Address</th>
              <th>Edit</th>
              <th>Delete</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              <th>Id</th>
              <th>Title</th>
              <th>Contact Name</th>
              <th>Full Name</th>
              <th>Mobile</th>
              <th>Address</th>
                </tr>
            </tfoot>
         </table>

             
       </div>
   </section>
   <?php include_once '../Shared/footer.php';?>
 </body>
</html>