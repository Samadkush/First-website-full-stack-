<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <img src= "logo.jpg" alt="Final International University" class="logo">
  <title>Ethics Form 1</title>
  <link rel="stylesheet" href="projectform.css">
</head>

<body>
  <div class="container">
   
    <h1>
      ETHICS COMMITTEE PROJECT INFORMATION FORM
 </h1>
  

  <form action="save_data.php" method="post"    > <!-- FOR PHP PAGE(START) -->

    <form>


     <!-- Start of simple Questions -->
 

    <label for="StudyTitle" class="center-align">1. Briefly describe the study to be conducted, including the sub-research questions, and hypotheses if any</label>
    <p class="center-align">
      <textarea name="StudyDescription" rows="8" cols="50"></textarea>
    </p>
  
    <label for="StudyTitle" class="center-align">2. Explain the data collection plan, specifying the methods, scales, tools, and techniques to be used.

      <p>
          (Please hand in a copy of all types of instruments such as scales and questionnaires to be used in the study along with this document.)
      </p>
    </label>
    <p class="center-align">
      <textarea name="ExplainData" rows="8" cols="50"></textarea>
    </p> 
      
    <label for="StudyTitle" class="center-align">3. Write down the expected results of your study.</label>
    <p class="center-align">
      <textarea name="StudyResult" rows="8" cols="50"></textarea>
    </p>



     <!-- Start of simple Questions -->







    <!-- YES_NO1 -->

    <label for="StudyTitle" class="center-align">
      4. Does your study involve items/procedures that may jeopardize the physical and/or psychological wellbeing of the participants or that may be distressing for them?.
    </label>
    <p>If yes, please explain. Specify the precautions that will be taken to eliminate or minimize the effects of these items/procedures</p>
    <br>
    <input type="radio" name="yesno1" value="yes" onclick="toggleInputBox(true, 'inputBoxContainer1')"> Yes
    <input type="radio" name="yesno1" value="no" onclick="toggleInputBox(false, 'inputBoxContainer1')"> No

    <div id="inputBoxContainer1" style="display: none;">
      <textarea name="StudyDescription" rows="8" cols="50"></textarea>
    </div>
    

        <!-- YES_NO2 -->
     
    <label for="StudyTitle" class="center-align">
      <p>5. Will the participants be kept totally/partially uninformed of the aim of the study (i.e. is there deception)?.</p>
      <p>If yes, explain why. Indicate how this will be explained to the participants at the end of the data collection in debriefing the participants</p>
    </label>
    <br>
    <input type="radio" name="yesno2" value="yes" onclick="toggleInputBox(true, 'inputBoxContainer2')"> Yes
    <input type="radio" name="yesno2" value="no" onclick="toggleInputBox(false, 'inputBoxContainer2')"> No

    <div id="inputBoxContainer2" style="display: none;">
      <textarea name="StudyDescription" rows="8" cols="50"></textarea>
    </div>







    <label for="StudyTitle" class="center-align"> <p>6. Indicate the potential contributions of the study to your research area and/or the society.</p></label>
    <p class="center-align">
      <textarea name="StudyResult" rows="8" cols="50"></textarea>
    </p>




        <!-- YES_NO3 -->

    <label for="StudyTitle" class="center-align">
      <p>7. Have you completed any previous research project?.</p>
      <p>
          If your answer is yes, write down the titles, and dates of previous research projects you have conducted or that you have taken part in and the names of funding institution(s) if any
      </p>
    </label>
    <br>
    <input type="radio" name="yesno3" value="yes" onclick="toggleInputBox(true, 'inputBoxContainer3')"> Yes
    <input type="radio" name="yesno3" value="no" onclick="toggleInputBox(false, 'inputBoxContainer3')"> No

    <div id="inputBoxContainer3" style="display: none;">
      <textarea name="StudyDescription" rows="8" cols="50"></textarea>
    </div>


       <!-- start of Questions with Signature -->

    


       <p>
        <label for="Name" >Researcher’s name and surname:</label>
        <input type="text" class="new" size="45" name="Name">
        <label for="ResearcherSignature"><p>Signature</p></label>
        <div>
          <canvas id="researcherCanvas" width="300" height="100" style="border: 1px solid black;"></canvas>
          <button type="button" onclick="clearCanvas('researcherCanvas')">Clear Signature</button>
        </div>
      </p>
      
      <p>
        <label for="Name">Supervisor’s / Advisor’s name and surname</label>
        <input type="text" class="new" size="60" name="Name">
        <label for="SupervisorSignature"><p>Signature</p></label>
        <div>
          <canvas id="supervisorCanvas" width="300" height="100" style="border: 1px solid black;"></canvas>
          <button type="button" onclick="clearCanvas('supervisorCanvas')">Clear Signature</button>
        </div>
      </p>
  

        


       <!-- END of Questions with Signature -->




    
    <input type="submit" value="Submit" class="submit-button">



    </form>

     



  </form>   <!-- FOR PHP PAGE(END) -->


  <!-- Script for the submit button -->
  <script> 
    function toggleInputBox(show, containerId) {
      var inputBoxContainer = document.getElementById(containerId);
      inputBoxContainer.style.display = show ? "block" : "none";
    } 
  </script>




    <!-- Script to get the signature -->

<script>
    function clearCanvas(canvasId) {
      const canvas = document.getElementById(canvasId);
      const ctx = canvas.getContext("2d");
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }


    function startDrawing(canvasId) {
      const canvas = document.getElementById(canvasId);
      const ctx = canvas.getContext("2d");
      let isDrawing = false;

      canvas.addEventListener("mousedown", (e) => {
        isDrawing = true;
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        ctx.beginPath();
        ctx.moveTo(x, y);
      });

      canvas.addEventListener("mousemove", (e) => {
        if (isDrawing) {
          const rect = canvas.getBoundingClientRect();
          const x = e.clientX - rect.left;
          const y = e.clientY - rect.top;
          ctx.lineTo(x, y);
          ctx.stroke();
        }
      });

      canvas.addEventListener("mouseup", () => {
        isDrawing = false;
      });

      canvas.addEventListener("mouseleave", () => {
        isDrawing = false;
      });
    }

    startDrawing("researcherCanvas");
    startDrawing("supervisorCanvas");




  </script>

   <!--  END of signature's Script  -->






  </div>
</body>

</html>