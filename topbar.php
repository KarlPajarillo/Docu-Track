<?php include 'db_connect.php' ;

$numrows = $conn->query("SELECT * from notifications where user_id = {$_SESSION['login_id']} and status = 'unread' order by  unix_timestamp(date_created) desc ")->num_rows;
?>

<!-- Navbar -->
  <nav class=" main-header docu-header navbar navbar-expand navbar-primary navbar-dark " style="background: #0d2ddc;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
      <li>
        <a class="nav-link header-title"  style="color: #e1d467;font-size: 25px; margin-top: -7px" href="./" role="button"> <large><b><?php echo $_SESSION['system']['name'] ?></b></large></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
     <li class="nav-item dropdown">
        <div class="nav-link"  data-toggle="dropdown" aria-expanded="true">
          <span class="fa fa-bell" style="font-size: 20px;"></span>
          <?php if ($numrows > 0) : ?>
              <span class="badge badge-danger" style="font-size: 10px; vertical-align: top; margin-left: -10px"><?php echo $numrows ?></span>
          <?php endif; ?>
        </div>
        <div class="dropdown-menu notif-dropdown">
          <?php 
            $redirect_to = ($_SESSION['login_type'] == 5 ? 'created_transactions' : 'document_transactions');
            $qry = $conn->query("SELECT n.*, p.destined_to, p.status as pstatus from notifications n inner join parcels p on n.reference_number = p.reference_number where n.user_id = {$_SESSION['login_id']} order by  unix_timestamp(n.date_created) desc ");
              while($row= $qry->fetch_assoc()){
                if(!in_array($_SESSION['login_id'], explode(',,', substr($row['destined_to'], 1, -1)))){
                  if($row['status']=='unread'){
                    echo '<a class="dropdown-item notif unread" data-id="'.$row['id'].'" data-to="index.php?page='.$redirect_to.'&search='.$row['reference_number'].'">'.$row['message'].'</a>';
                  } else {
                    echo '<a class="dropdown-item notif read" data-id="'.$row['id'].'" data-to="index.php?page='.$redirect_to.'&search='.$row['reference_number'].'">'.$row['message'].'</a>';
                  }
                } else {
                  $redirection = ($row['pstatus'] == 2 ? 'document_transactions' : 'files_received');
                  echo '<a class="dropdown-item notif read" data-id="'.$row['id'].'" data-to="index.php?page='.$redirection.'&search='.$row['reference_number'].'">'.$row['message'].'</a>';
                }
                
              }
          ?>
        </div>
      </li>
     <li class="nav-item dropdown" style="margin-left: -15px">
        <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
          <span>
            <div class="d-felx badge-pill">
              <span class="fa fa-user mr-2" style="font-size: 18px;"></span>
              <span style="font-size: 18px;"><b><?php echo ucwords($_SESSION['login_lastname'].', '.$_SESSION['login_firstname']) ?></b></span>
              <span class="fa fa-angle-down ml-2"></span>
            </div>
          </span>
        </a>
        <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
          <a class="dropdown-item" href="javascript:void(0)" id="manage_account"><i class="fa fa-cog"></i> Manage Account</a>
          <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <style>
    .notif-dropdown{
      right: -100px !important;
      background:#f0f0f5;
      border-radius: 0 0 10px 10px;
      border:1px solid gray;
      top:46px;
      max-width: 500px;
      width: 500px;
    }

    .notif:hover{
      background: lightgray;
    }

    .read{
      font-weight: 400;
      cursor: pointer;
    }

    .unread{
      font-weight: bold;
      cursor: pointer;
    }
  </style>
  <script>
     $('#manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id=<?php echo $_SESSION['login_id'] ?>')
      })

    $('.notif').click(function(){
      start_load()
      $.ajax({
        url:'ajax.php?action=update_notif',
        method:'POST',
        data:{
          id:$(this).attr('data-id'),
          status:'read',
          goto: $(this).attr('data-to')
          },
        success:function(resp){
          if(resp!=0){
            // alert_toast("Document successfully sent",'success')
            setTimeout(function(){
              location.href = resp;
            })

          }
        }
      })
    })
  </script>
