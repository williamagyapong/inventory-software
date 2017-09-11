     <!-- Project approval alert modal -->
   <div id="nmodal" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-round-large" style="max-width:600px">
      <header class="w3-container w3-blue"> 
        <span onclick="hideElement('nmodal')" 
        class="w3-button w3-hover-red w3-display-topright w3-xlarge">&times;</span>
        <h2>Project Approval</h2>
      </header>

      <div class="w3-container w3-text-red w3-large w3-bold">
        <p><b>Please confirm that the Registration Info entered by Storekeeper is correct</b></p>
      </div>

      <footer class="w3-container w3-light-grey">
       <div class="w3-right">
        <a href="show_project.php" class="w3-button">Show</a>
        <button class="w3-button" onclick="hideElement('nmodal');setSession('print_session')">Print</button>
        <?php 
         echo "<a href=\"#\" class=\"w3-button\" onclick=\"hideElement('nmodal');updateProject('".$projectsForApproval[0]->id."','remind_later')\">Remind Me Later</a>"
        ?>
       </div>
      </footer>
    </div>
   </div>
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
             <!-- Not satisfied dialog box -->
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
          <button type="reset" class="w3-button">Clear</button>
          <button type="submit" name="p_token" value="notsatisfied" class="w3-button" onclick="document.getElementById('notsatisfied-modal').style.display='none'">Submit</button>
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
  