<?php include('db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_type'] != 1)
  $twhere = "  ";

$docs = $conn->query("SELECT *, length(doc_name) as doclength FROM documents order BY doclength");
?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
<!-- <div id="admin">
  <div class="row">
    <div class="col-md-12">
      <h3>Hello Admin!</h3>
    </div>
  </div>
</div> -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <a href="./index.php?page=department_list" class="small-box bg-light shadow-sm border">
              <div class="inner" style="background:orange;color:white">
                <h3><?php echo $conn->query("SELECT * FROM branches")->num_rows; ?></h3>

                <p>Department's</p>
              </div>
              <div class="icon" style="color:white;opacity:50%">
                <i class="fa fa-building"></i>
              </div>
            </a>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
            <a href="./index.php?page=user_list" class="small-box bg-light shadow-sm border">
              <div class="inner" style="background:yellow;color:white">
                <h3><?php echo $conn->query("SELECT * FROM users where type != 1")->num_rows; ?></h3>

                <p>User's</p>
              </div>
              <div class="icon" style="color:white;opacity:50%">
                <i class="fa fa-users"></i>
              </div>
            </a>
          </div>
          <div class="col-12 col-sm-6 col-md-4">
            <a href="./index.php?page=document_transactions" class="small-box bg-light shadow-sm border">
              <div class="inner" style="background:blue;color:white">
                <h3><?php echo $conn->query("SELECT * FROM parcels")->num_rows; ?></h3>

                <p>All Transactions</p>
              </div>
              <div class="icon" style="color:white;opacity:50%">
                <i class="fa fa-boxes"></i>
              </div>
            </a>
          </div>
          <hr>
          <?php 
              // $status_arr = array("Item Accepted by Courier","Collected","Shipped","In-Transit","Arrived At Destination","Out for Delivery","Ready to Pickup","Delivered","Picked-up","Unsuccessfull Delivery Attempt");
              $status_arr = array("Sent","Approved", "Denied");
              $color_arr = array("darkviolet","green", "red");
              foreach($status_arr as $k =>$v):
          ?>
          <div class="col-12 col-sm-6 col-md-4">
            <a href="./index.php?page=document_transactions&s=<?php echo $k?>" class="small-box bg-light shadow-sm border">
              <div class="inner" style="background:<?php echo $color_arr[$k] ?>;color:white">
                <h3><?php echo $conn->query("SELECT * FROM parcels where status = {$k} ")->num_rows; ?></h3>

                <p><?php echo $v ?></p>
              </div>
              <div class="icon" style="color:white;opacity:50%">
                <i class="fa fa-boxes"></i>
              </div>
            </a>
          </div>
            <?php endforeach; ?>
        </div>

<?php else: ?>
  <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <a href="./index.php?page=document_transactions" class="small-box bg-light shadow-sm border">
              <div class="inner" style="background:blue;color:white">
                <h3><?php echo $conn->query("SELECT * FROM parcels WHERE sender_name = ".$_SESSION['login_id']." or recipient_name = ".$_SESSION['login_id']." or created_by = ".$_SESSION['login_id']."")->num_rows; ?></h3>

                <p>All Transactions</p>
              </div>
              <div class="icon" style="color:white;opacity:50%">
                <i class="fa fa-boxes"></i>
              </div>
            </a>
          </div>
          <?php if($_SESSION['login_type'] == 5): ?>
           <div class="col-12 col-sm-6 col-md-4">
            <a href="./index.php?page=created_transactions" class="small-box bg-light shadow-sm border">
              <div class="inner" style="background:orange;color:white">
                <h3><?php echo $conn->query("SELECT * FROM parcels where created_by = ".$_SESSION['login_id']."")->num_rows; ?></h3>
                <p>Created Transactions</p>
              </div>
              <div class="icon" style="color:white;bg-white;opacity:50%">
                <i class="fa fa-box"></i>
              </div>
            </a>
          </div>
          <?php endif; ?>
          <hr>
          <?php 
              $status_arr = array("Sent","Approved", "Denied");
              $color_arr = array("darkviolet","green", "red");
               foreach($status_arr as $k =>$v):
          ?>
          <div class="col-12 col-sm-6 col-md-4">
            <a href="./index.php?page=document_transactions&s=<?php echo $k ?>" class="small-box bg-light shadow-sm border">
              <div class="inner" style="background:<?php echo $color_arr[$k] ?>;color:white">
                <h3><?php echo $conn->query("SELECT * FROM parcels where (sender_name = ".$_SESSION['login_id']." or recipient_name = ".$_SESSION['login_id']." or created_by = ".$_SESSION['login_id'].") and status = {$k} ")->num_rows; ?> </h3>

                <p><?php echo $v.' Transactions' ?></p>
              </div>
              <div class="icon" style="color:white;opacity:50%">
                <i class="fa fa-box"></i>
              </div>
            </a>
          </div>
            <?php endforeach; ?>
        </div>
          
<?php endif; ?>
<?php if($_SESSION['login_type'] <= 3 ): ?>
  <?php 
      $branches = $conn->query("SELECT * FROM branches");
      foreach($branches as $bkey => $bvalue):
  ?>
<div class="row mb-2">
  <div class="content-header col-sm-12" style="display:block">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Transaction Documents ( <?php echo $bvalue['department'] ?> )</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <hr class="border-primary">
            <?php 
              foreach($docs as $key => $value):
                $users_c = $conn->query("SELECT p.created_by, p.file_name,  u.* FROM parcels p inner join users u on p.created_by = u.id inner join branches b on u.branch_id = b.id WHERE u.branch_id = ".$bvalue['id']." and u.id != ".$_SESSION['login_id']." and doc_type = ".$value['id']);
                $users_a = $conn->query("SELECT p.created_by, p.file_name, u.* FROM parcels p inner join users u on p.created_by = u.id inner join branches b on u.branch_id = b.id WHERE u.branch_id = ".$bvalue['id']." and u.id != ".$_SESSION['login_id']." and doc_type = ".$value['id']." and status = '1'");
                $creates = $users_c->num_rows;
                $approves = $users_a->num_rows;
                $total = $creates + $approves;
            ?>
              <div class="row" id="main-menu">
                <div>
                  <nav id="menu-area">
                    <ul>
                      <li id="menu-1">
                        <a href="#" >
                          <i class="nav-icon fas fa-folder"></i>
                          <?php echo $value['doc_name'].' &emsp;<i class="fa fa-file mr-2">&nbsp;'.$total.'</i>' ?>
                          <span>
                            <i class="right fas fa-angle-left"></i>
                          </span>
                        </a>
                        <ul class="submenu-1">
                          <?php 
                            // for created docs per user
                            // $qry = $conn->query("SELECT *, concat(firstname, ' ', lastname) as name FROM users WHERE branch_id = ".$_SESSION['login_branch_id']." and id != ".$_SESSION['login_id']);
                            // foreach($qry as $key => $value):
                          ?>
                            <li class="">
                              <a href="#">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <span>Created</span> &emsp;
                                <i class="fa fa-user mr-2"></i><?php echo $creates ?>
                              </a>
                              <ul class="submenu-2">
                                <?php
                                  foreach($users_c as $k => $val):
                                    if($creates != 0):
                                ?>
                                  <li><a href="assets/uploads/<?php echo $val['file_name'] ?>" target="blank"><i class="fa fa-user mr-2"></i><?php echo $val['firstname']." ".$val['lastname']." -- ".$val['file_name'] ?></a></li>
                                <?php endif; endforeach;?>
                                <?php
                                  if($creates == 0):
                                ?>
                                  <li><a href="#"><i class="fa fa-user mr-2"></i>NO FILES AVAILABLE!!!</a></li>
                                <?php endif;?>
                              </ul>
                            </li>
                            <li class="">
                              <a href="#" class="">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <span>Approved</span> &emsp;
                                <i class="fa fa-user mr-2"></i><?php echo $approves ?>
                              </a>
                              <ul class="submenu-2">
                              <?php
                                  foreach($users_a as $k => $val):
                                    if($approves != 0):
                                ?>
                                  <li><a href="assets/uploads/<?php echo $val['file_name'] ?>" target="blank"><i class="fa fa-user mr-2"></i><?php echo $val['firstname']." ".$val['lastname']." -- ".$val['file_name'] ?></a></li>
                                <?php endif; endforeach;?>
                                <?php
                                  if($approves == 0):
                                ?>
                                  <li><a href="#"><i class="fa fa-user mr-2"></i>NO FILES AVAILABLE!!!</a></li>
                                <?php endif;?>
                              </ul>
                            </li>
                          <?php //endforeach; ?>
                        </ul>
                      </li>
                    </ul>
                  </nav>
                </div>
            </div>
          <?php endforeach; ?>
      </div><!-- /.container-fluid -->
  </div>
</div>
  <?php endforeach; ?>
<?php endif; ?>
<?php if($_SESSION['login_type'] == 4): ?>
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Document Transactions</h1>
          </div><!-- /.col -->
      </div><!-- /.row -->
      <hr class="border-primary">
          <?php 
            foreach($docs as $key => $value):
              $users_c = $conn->query("SELECT p.created_by, p.file_name,  u.* FROM parcels p inner join users u on p.created_by = u.id inner join branches b on u.branch_id = b.id WHERE u.branch_id = ".$_SESSION['login_branch_id']." and u.id != ".$_SESSION['login_id']." and doc_type = ".$value['id']);
              $users_a = $conn->query("SELECT p.created_by, p.file_name, u.* FROM parcels p inner join users u on p.created_by = u.id inner join branches b on u.branch_id = b.id WHERE u.branch_id = ".$_SESSION['login_branch_id']." and u.id != ".$_SESSION['login_id']." and doc_type = ".$value['id']." and status = '1'");
              $creates = $users_c->num_rows;
              $approves = $users_a->num_rows;
              $total = $creates + $approves;
          ?>
            <div class="row" id="main-menu">
              <div>
                <nav id="menu-area">
                  <ul>
                    <li id="menu-1">
                      <a href="#" >
                        <i class="nav-icon fas fa-folder"></i>
                        <?php echo $value['doc_name'].' &emsp;<i class="fa fa-file mr-2">&nbsp;'.$total.'</i>' ?>
                        <span>
                          <i class="right fas fa-angle-left"></i>
                        </span>
                      </a>
                      <ul class="submenu-1">
                        <?php 
                          // for created docs per user
                          // $qry = $conn->query("SELECT *, concat(firstname, ' ', lastname) as name FROM users WHERE branch_id = ".$_SESSION['login_branch_id']." and id != ".$_SESSION['login_id']);
                          // foreach($qry as $key => $value):
                        ?>
                          <li class="">
                            <a href="#">
                              <i class="fas fa-angle-right nav-icon"></i>
                              <span>Created</span> &emsp;
                              <i class="fa fa-user mr-2"></i><?php echo $creates ?>
                            </a>
                            <ul class="submenu-2">
                              <?php
                                foreach($users_c as $k => $val):
                                  if($creates != 0):
                              ?>
                                <li><a href="assets/uploads/<?php echo $val['file_name'] ?>" target="blank"><i class="fa fa-user mr-2"></i><?php echo $val['firstname']." ".$val['lastname']." -- ".$val['file_name'] ?></a></li>
                              <?php endif; endforeach;?>
                              <?php
                                if($creates == 0):
                              ?>
                                <li><a href="#"><i class="fa fa-user mr-2"></i>NO FILES AVAILABLE!!!</a></li>
                              <?php endif;?>
                            </ul>
                          </li>
                          <li class="">
                            <a href="#" class="">
                              <i class="fas fa-angle-right nav-icon"></i>
                              <span>Approved</span> &emsp;
                              <i class="fa fa-user mr-2"></i><?php echo $approves ?>
                            </a>
                            <ul class="submenu-2">
                            <?php
                                foreach($users_a as $k => $val):
                                  if($approves != 0):
                              ?>
                                <li><a href="assets/uploads/<?php echo $val['file_name'] ?>" target="blank"><i class="fa fa-user mr-2"></i><?php echo $val['firstname']." ".$val['lastname']." -- ".$val['file_name'] ?></a></li>
                              <?php endif; endforeach;?>
                              <?php
                                if($approves == 0):
                              ?>
                                <li><a href="#"><i class="fa fa-user mr-2"></i>NO FILES AVAILABLE!!!</a></li>
                              <?php endif;?>
                            </ul>
                          </li>
                        <?php //endforeach; ?>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
          </div>
        <?php endforeach; ?>
    </div><!-- /.container-fluid -->
</div>
<?php endif; ?>
<style>
  #admin>div{
    text-align: center;
    color: #fff;
    background: #555555;
    padding: 50px;
  }
  #main-menu{
    float: left;
    height: 60px;
    line-height: 20px;
    width: 100%;
  }
  #main-menu>div{
    width: 100%;
    /* min-width: 20%;
    max-width: 50%; */
  }
  nav#menu-area{
    margin: 0 auto;
    padding: 0 15px;
    position: relative;
    background: #212529;
    width: 100%;
  }
  nav#menu-area ul li{
    background: #f8f9fa;
    border: 1px solid #343a40;
    float: left;
    position: relative;
    font-size: 20px;
    list-style: none;
    margin: 0;
    padding: 0;
    text-align: center;
    text-transform: uppercase;
    width: 100%;
  }
  nav#menu-area ul li a{
    color: #343a40;
    text-decoration: none;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: inline-block;
    line-height: 60px;
  }
  nav#menu-area ul li:hover>a{
    color: #fff;
    text-align: left;
    text-overflow: hidden;
    margin-left: 20px;
    width: 100%;
  }
  nav#menu-area ul li:hover{
    background: #555555;
    text-overflow: hidden;
    width: 30%;
    transition: width 0.1s 0.1s ease-out;
  }
  nav#menu-area ul li:hover>a>span>i{
    transform: rotate(-90deg);
  }
  nav#menu-area ul li ul.submenu-1{
    z-index: 1;
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
    position: absolute;
    right: -182px;
    top: -1px;
    background: #212529;
    width: 50%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-out, visibility 0.1s 0.1 linear;
  }
  nav#menu-area ul li ul.submenu-1 li{
    border: 1px solid #343a40;
    clear: both;
    margin-top: -15px;
    padding: 0;
    width: 100%;
    transition: opacity 0.15s 0.15s ease-out, margin 0.3s 0.1s ease-out;
  }
  nav#menu-area ul li:hover ul.submenu-1{
    opacity: 1;
    visibility: visible;
  }
  nav#menu-area ul li:hover ul.submenu-1 li{
    margin-top: 0;
    opacity: 1;
  }
  nav#menu-area ul li:hover ul.submenu-1 li a{
    width: 100%;
  }
  nav#menu-area ul li ul.submenu-1 li ul.submenu-2{
    float: left;
    list-style: none;
    margin: 0;
    padding: 0;
    position: absolute;
    left: 80%;
    top: -1px;
    background: #212529;
    width: 400%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s 0.01s ease-in-out, left 0.2s 0.1s ease-out, visibility 0.1s 0.1s linear;
  }
  ul.submenu-1 li ul.submenu-2{
    border: none;
    border-bottom: 1px solid #ccc;
    clear: both;
    margin: 0;
    padding: 0;
    width: 100%;
    opacity: 1;
  }
  nav#menu-area ul li ul.submenu-1 li:hover ul.submenu-2{
    opacity: 1;
    left: 100%;
    visibility: visible;
    text-align: center !important;
    max-height:400px;
    overflow: hidden;
    overflow-y: scroll;
  }
</style>
<script>
  $(document).ready(function(){
    $('.nav-link.dropper').click(function(){
        $('.nav-link.dropper').addClass('menu-is-opening')
        $('.nav-drop').addClass('nav-dropped')
    })
  })

</script>
