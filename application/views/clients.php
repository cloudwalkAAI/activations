
<h1 class="text-center">Clients</h1>

  <div class="row">
    <div class="column large-6 medium-6 small-12 dash_col">
      <div class="row collapse prefix-radius">
        <div class="small-2 columns">
          <span class="prefix fi-magnifying-glass medium"></span>
        </div>
        <div class="small-10 columns">
          <input id="inp_search_client" class="left" type="text" placeholder="Search..">
        </div>
      </div>
    </div>
    <div class="column large-6 medium-6 small-12 dash_col">
      <a href="#" data-reveal-id="myModal" class="button tiny fi-plus right">  Add Client</a>
    </div>
  </div>
<!-- Reveal Modals begin -->

      <div id="myModal" class="reveal-modal small" data-reveal aria-hidden="true" role="dialog">
        <h2 class="text-center">Add Client</h2>
        <div id="alert_box_client_s" data-alert class="alert-box radius hide-normal">
          <a href="#" class="close">&times;</a>
        </div>
        <form id="form_client" method="post">
        <div class="row">
          <div class="small-12 columns">
            <input type="text" id="inp_companyname" name="inp_companyname" placeholder="Company Name">
          </div>
        </div>
        <div class="row">
          <div class="small-12 columns">
            <input type="text" id="inp_contactperson" name="inp_contactperson" placeholder="Contact Person">
          </div>
        </div>
        <div class="row">
          <div class="small-12 columns">
            <input type="text" id="inp_contactnumber" name="inp_contactnumber"  placeholder="Contact Number">
          </div>
        </div>
        <div class="row">
          <div class="small-12 columns">
            <input type="text" id="inp_birthday" name="inp_birthday" placeholder="Birthdate">
          </div>
        </div>
        <div class="row">
          <div class="small-12 columns">
            <input type="text" id="inp_email" name="inp_email" placeholder="Email Address">
          </div>
        </div>
        <div class="row">
          <div class="small-12 columns text-right">
            <a href="#" class="button success" id="btn_save_client">Save</a>
          </div>
        </div>
      </form>
      <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>

  <div id="myModalclient_u" class="reveal-modal small" data-reveal aria-hidden="true" role="dialog">
    <h2 class="text-center">Client Form</h2>

    <div id="alert_box_client" data-alert class="alert-box radius hide-normal">
      <a href="#" class="close">&times;</a>
    </div>

    <form id="form_client_u" action="" method="post" data-abide>
      <input type="hidden" id="hid_client_id" name="hid_client_id">
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_companyname_u" name="inp_companyname_u" class="req" placeholder="Company Name">
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_contactperson_u" name="inp_contactperson_u" class="req" placeholder="Contact Person">
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
            <textarea name="inp_contactnumber_u" id="inp_contactnumber_u" class="req" cols="15" rows="3" placeholder="Contact Number"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_birthday_u" name="inp_birthday_u" class="req" placeholder="Birthday">
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_email_u" name="inp_email_u" class="req" placeholder="Email Address">
        </div>
      </div>
      <div class="row">
        <div class="small-offset-6 small-3 columns">
          <button class="button alert" aria-label="Close">Cancel</button>
        </div>
        <div class="small-3 columns">
          <button class="button success" id="btn_update_client">Update</button>
        </div>
      </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  </div>

  <div class="row">
    <div class="small-12 medium-12 large-12 column">
      <table id="client_table">
        <thead>
          <tr>
            <th width="300">Client No.</th>
            <th width="600">Company Name</th>
            <th width="600">Contact Person</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if( isset($client_list) ){
              foreach( $client_list as $row ){
                echo '<tr><td><a class="load_client" href="#" alt="'.$row['client_id'].'">'.str_pad( $row['client_id'], 6, "0", STR_PAD_LEFT ).'</a></td><td>'.$row['company_name'].'</td><td>'.$row['contact_person'].'</td></tr>';
              }
            }else{
              echo '<tr><td class="text-center" colspan="3">Empty</td></tr>';
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>