     <!-- Project approval alert modal -->
  <?php if(!empty($projectsForApproval)):?>
   <div id="nmodal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <span onclick="hideElement('nmodal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h2>Project Approval</h2>
      </header>

      <div class="w3-container w3-text-red w3-large w3-bold">
        <p>Please confirm that the Registration Info entered by Storekeeper is correct</p>
      </div>

      <footer class="w3-container w3-light-grey">
       <div class="w3-right">
        <a href="show.php" class="w3-button">Show</a>
        <button class="w3-button" onclick="hideElement('nmodal');setSession('print_project_session')">Print</button>
        <?php 
         echo "<a href=\"#\" class=\"w3-button\" onclick=\"hideElement('nmodal');updateProject('".$projectsForApproval[0]->id."','remind_later')\">Remind Me Later</a>"
        
        ?>
       </div>
      </footer>
    </div>
   </div>
   <?php endif;?>
        <!-- Bill approval alert modal -->
   <?php if(!empty($billsForApproval)):?>
   <div id="nbillmodal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <span onclick="hideElement('nbillmodal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h2>Required Materials Bill Approval</h2>
      </header>

      <div class="w3-container w3-text-red w3-large w3-bold">
        <p>Please confirm that the Bill of Required Materials quantity entered by Storekeeper is correct</p>
      </div>

      <footer class="w3-container w3-light-grey">
       <div class="w3-right">
        <a href="show.php?bill=<?php echo sha1(md5($billsForApproval[0]->id));?>" class="w3-button">Show</a>
        <a href="show.php?print&bill=<?php echo sha1(md5($billsForApproval[0]->id));?>" class="w3-button" onclick="hideElement('nbillmodal');setSession('print_bill_session')">Print</a>
        <?php 
         echo "<a href=\"#\" class=\"w3-button\" onclick=\"hideElement('nbillmodal');updateProject('".$billsForApproval[0]->id."','remind_later','bill_status')\">Remind Me Later</a>"
        ?>
       </div>
      </footer>
    </div>
   </div>
   <?php endif;?>
          <!-- Project reminder alert modal -->
   <?php if($admin->role=='manager'):?>
   <div id="rmodal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <span onclick="hideElement('rmodal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h3>Project Approval Reminder</h3>
      </header>

      <div class="w3-container w3-text-red w3-large w3-bold w3-center">
        <p><b><?php echo Notification::getProjectReminders();?></b></p>
      </div>
      <footer class="w3-container w3-light-grey">
       <div class="w3-right">
        <button class="w3-button" onclick="document.getElementById('rmodal').style.display='none';loadElement('reminded', 'reminded')">Show</button>
        <button class="w3-button" onclick="hideElement('rmodal')">Cancel</button>
       </div>
      </footer>
    </div>
   </div>
   <?php endif;?>
             <!-- Not satisfied registration dialog box -->
   <div id="notsatisfied-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <span onclick="hideElement('notsatisfied-modal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h3>Registration Dissatisfaction Note</h3>
      </header>
      <form action="action_page.php" method="post">
        <div class="w3-container w3-text-red w3-large w3-bold w3-center">
          
              <textarea class="w3-input w3-border w3-margin-top" name="notes" placeholder="Please write here" required="required"></textarea>
              <!-- set the value field when this modal is displayed -->
              <input type="hidden" name="projectId" id="nspId">
          
        </div>

        <footer class="w3-container w3-light-grey">
         <div class="w3-right">
          <input type="hidden" name="field_name" value="status">
          <button type="reset" class="w3-button">Clear</button>
          <button type="submit" name="p_token" value="notsatisfied" class="w3-button" onclick="document.getElementById('notsatisfied-modal').style.display='none'">Submit</button>
         </div>
        </footer>
      </form>
    </div>
  </div>
            <!-- Not satisfied required materials bill dialog box -->
   <div id="notsatisfied-bill-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <span onclick="hideElement('notsatisfied-bill-modal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h3>Bill Dissatisfaction Note</h3>
      </header>
      <form action="action_page.php" method="post">
        <div class="w3-container w3-text-red w3-large w3-bold w3-center">
          
              <textarea class="w3-input w3-border w3-margin-top" name="notes" placeholder="Please write here" required="required"></textarea>
              <!-- set the value field when this modal is displayed -->
              <input type="hidden" name="projectId" id="nSBilledProjectId">
          
        </div>

        <footer class="w3-container w3-light-grey">
         <div class="w3-right">
          <input type="hidden" name="field_name" value="bill_status">
          <button type="reset" class="w3-button">Clear</button>
          <button type="submit" name="p_token" value="notsatisfied" class="w3-button" onclick="document.getElementById('notsatisfied-bill-modal').style.display='none'">Submit</button>
         </div>
        </footer>
      </form>
    </div>
  </div>
               <!-- Reconciliation dialog box -->
   <div id="reconcile-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <span onclick="hideElement('reconcile-modal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h3>Registration Reconciliation</h3>
      </header>
      <form action="action_page.php" method="post">
        <div class="w3-container w3-text-red w3-large w3-bold w3-center">
          
              <textarea class="w3-input w3-border w3-margin-top" name="notes" placeholder="Please write here"></textarea>
              <!-- set the value field when this modal is displayed -->
              <input type="hidden" name="projectId" id="nspId">
          
        </div>

        <footer class="w3-container w3-light-grey">
         <div class="w3-right">
          <button type="reset" class="w3-button">Clear</button>
          <button type="submit" name="p_token" value="notsatisfied" class="w3-button" onclick="document.getElementById('notsatisfied-modal').style.display='none'">Submit</button>
         </div>
        </footer>
      </form>
    </div>
  </div>
         <!-- deletion failure alert modal -->
   <div id="delete-modal" class="w3-modal w3-round">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <h3 style="display: inline;">Alert</h3>
      </header>

      <div class="w3-container w3-large w3-bold w3-padding-left">
        
         <p class="w3-padding w3-left"><img src="images/warning.png" width="50" height="40"></p>
        <p class="w3-margin-top w3-text-red">
         <b>Sorry, this record cannot be deleted!</b><br>
         <span class="w3-button w3-text-blue w3-small" onclick="$('#details').toggle()">View Details</span>
         <div id="details" style="display: none;margin-left: 20px;">
            <li>A bill has been prepared with this material</li>
            <li>The material might also be in use</li>
            <li>You can consult software developer for help</li>
         </div>
        </p>
      </div>
      <footer class="w3-container w3-light-grey">
       <div class="w3-right">
        <button class="w3-button my-button" onclick="hideElement('delete-modal');$('#details').css('display','none')"><b>OK</b></button>
       </div>
      </footer>
    </div>
   </div>
     