
<h1 class="text-center">Productions</h1>

  <div class="row">
    <div class="column large-5 medium-5 small-12 dash_col">
      <div class="row collapse prefix-radius">
        <div class="small-2 columns">
          <span class="prefix fi-magnifying-glass medium"></span>
        </div>
        <div class="small-10 columns">
          <input type="text" placeholder="Search..">
        </div>
      </div>
    </div>
<form>
    <div class="column large-7 medium-7 small-12 dash_col">
      <div class="row collapse prefix-radius">
        <div class="large-6 medium-6 small-12 columns">
          <select name="sel_dept_ad" id="sel_dept_ad">
                <option value="0">Department</option>
            </select>
        </div>
        <div class="large-6 medium-6 small-12 columns">
          <div class="row">
            <div class="large-12 columns">
              <div class="row collapse">
                <div class="small-10 columns">
                  <input type="text" placeholder="File Name">
                </div>
                <div class="small-2 columns">
                  <a href="#" class="button postfix large fi-upload"></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="small-12 medium-12 large-12 column">
        <table>
          <thead>
            <tr>
              <th width="200">Job Order No.</th>
              <th width="200">Date Uploaded</th>
              <th width="200">File Name</th>
              <th width="200">Reference for</th>
              <th width="200">Download</th>
            </tr>
          </thead>
          <tbody>
            <?php
                  $production_data = $this->db->get_where( 'project_attachments', array( 'reference_for' => 'production' ) );
                  if ($production_data->num_rows() > 0)
                  {
                      foreach ( $production_data->result() as $row )
                      {
                          $query = $this->db->get_where( 'job_order_list', array( 'jo_id' => $row->jo_id ) );
                          foreach ($query->result() as $jol) {
                              echo '<tr><td>'.$jol->jo_number.'</td>';
                          }
                          echo '
                          <td>'.$row->date_uploaded.'</td> 
                          <td>'.$row->file_name.'</td> 
                          <td>'.$row->reference_for.'</td> 
                          <td><a target="_blank" href="'.base_url($row->file_location).'">Download <i class="large fi-download"></i></a></td></tr>
                          ';

                          
                      }
                  }
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</form>