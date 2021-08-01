<?php
  $host = getenv("HOST");
  $dbport = getenv("DBPORT");
  $dbname = getenv("DATABASE");
  $user = getenv("DATABASE_USER");
  $pass = getenv("PASSWORD");
  
  if(isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $courseNum = $_POST['courseNum'];
    $phoneNumber = NULL;

    if (!empty($firstName) || !empty($email) || !empty($course) || !empty($courseNum)) {
      // create connection
      $connection = pg_connect("host=$host port=$dbport dbname=$dbname user=$user password=$pass");
      if (!$connection) {
         header("Location: https://www.coursenotifier.com/oops", true, 301);
         exit();
      }
  
      // set up query
      $query = "INSERT INTO userinformation (firstname, lastName, email, subject, classnumber, phonenumber) VALUES ($1, $2, $3, $4, $5, $6)";
      $result = pg_prepare($connection, "insert_entry", $query);
  
      $query2 = "INSERT INTO masterlist (firstname, lastName, email, subject, classnumber, phonenumber) VALUES ($1, $2, $3, $4, $5, $6)";
      $result2 = pg_prepare($connection, "insert_entry2", $query2);
  
      $query3 = "INSERT INTO subjectlist (subject) VALUES ($1) ON CONFLICT (subject) DO NOTHING";
      $result3 = pg_prepare($connection, "insert_entry3", $query3);
  
      // execute query
      $result = pg_execute($connection, "insert_entry", array($firstName, $lastName, $email, $course, $courseNum, $phoneNumber));
      $result2 = pg_execute($connection, "insert_entry2", array($firstName, $lastName, $email, $course, $courseNum, $phoneNumber));
      $result3 = pg_execute($connection, "insert_entry3", array($course));
    
      if ($result and $result2 and $result3) {
        header("Location: https://www.coursenotifier.com/success", true, 301);
        exit();
      }
      else {
        header("Location: https://www.coursenotifier.com/oops", true, 301);
        exit();
      }
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" type="image/png" href="favicon.png"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="jacob, christina">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>UWO Course Notifier</title>
    <!--<link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">-->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="custom-page.css" rel="stylesheet">
  </head>
  <div class="ellipse"></div>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <!--<img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
        <h1 style="color:#4A0084;margin-top:1em">Is your UWO course full?</h1>
	<p class="lead" style="color:#39266F;padding: 1em">If you're a Western student who can't get into a course/lab/tutorial because it's full, you're in the right place! Fill out the form below and we'll send you an email once a spot opens up.</p>
      </div>
      <div class="row">
        <div class="col-md-12 order-md-1">
          <form class="needs-validation" novalidate action="<?=$_SERVER['PHP_SELF'];?>" method="POST" onsubmit="return validate();">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName" style="color:#39266F"> First name*</label>
                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  First name required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName" style="color:#39266F">Last name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="">
              </div>
            </div>
            <div class="mb-3">
              <label for="email" style="color:#39266F">Email*</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]+$" onchange="form.retypeEmail.pattern = this.value;" required>
              <div class="invalid-feedback">
                Email address required.
              </div>
            </div>
            <div class="mb-3">
              <label for="email" style="color:#39266F">Re-type email*</label>
              <input type="email" class="form-control" id="retypeEmail" name="retypeEmail" placeholder="" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]+$" required>
              <div class="invalid-feedback">
                Email addresses must match.
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 mb-3">
                <label for="course" style="color:#39266F">Course*</label>
                <select class="custom-select d-block w-100" id="course" name="course" required>
                  <option value="">Choose...</option>
                  <option value="ACTURSCI">Actuarial Science</option>
                  <option value="AMERICAN">American Studies</option>
                  <option value="ANATCELL">Anatomy and Cell Biology</option>
                  <option value="ANTHRO">Anthropology</option>
                  <option value="APPLMATH">Applied Mathematics</option>
                  <option value="ARABIC">Arabic</option>
                  <option value="AH">Art History</option>
                  <option value="ARTHUM">Arts and Humanities</option>
                  <option value="ASTRONOM">Astronomy</option>
                  <option value="BIBLSTUD">Biblical Studies</option>
                  <option value="BIOCHEM">Biochemistry</option>
                  <option value="BIOLOGY">Biology</option>
                  <option value="BME"> Biomedical Engineering</option>
                  <option value="BIOSTATS"> Biostatistics</option>
                  <option value="BUSINESS"> Business Administration</option>
                  <option value="CALCULUS"> Calculus</option>
                  <option value="CGS"> Centre for Global Studies</option>
                  <option value="CBE"> Chem & Biochem Engineering</option>
                  <option value="CHEMBIO"> Chemical Biology </option>
                  <option value="CHEM"> Chemistry</option>
                  <option value="CSI"> Childhood & Social Institutions</option>
                  <option value="CHINESE"> Chinese </option>
                  <option value="CHURCH"> Church History</option>
                  <option value="CHURLAW"> Church Law</option>
                  <option value="CHURMUSI"> Church Music</option>
                  <option value="CEE"> Civil & Environmental Engineering</option>
                  <option value="CLASSICS"> Classical Studies</option>
                  <option value="CMBPROG"> Combined Program Enrollment</option>
                  <option value="COMMSCI"> Communication Sci & Disorders </option>
                  <option value="COMPLIT"> Comparative Lit & Culture</option>
                  <option value="COMPSCI"> Computer Science </option>
                  <option value="DANCE"> Dance </option>
                  <option value="DIGICOMM"> Digital Communication </option>
                  <option value="DIGIHUM"> Digital Humanities </option>
                  <option value="DISABST"> Disability Studies </option>
                  <option value="EARTHSCI"> Earth Sciences </option>
                  <option value="ECONOMIC"> Economics </option>
                  <option value="EELC"> Education English Language Cen </option>
                  <option value="ECE"> Elect & Computer Engineering </option>
                  <option value="ENGSCI"> Engineering Science </option>
                  <option value="ENGLISH"> English </option>
                  <option value="ENVIRSCI"> Environmental Science </option>
                  <option value="EPID"> Epidemiology </option>
                  <option value="EPIDEMIO"> Epidemiology & Biostatistics </option>
                  <option value="FIMS"> FIMS </option>
                  <option value="FAMLYSTU"> Family Studies & Human Develop </option>
                  <option value="FLDEDUC"> Field Education </option>
                  <option value="FILM"> Film Studies </option>
                  <option value="FINMOD"> Financial Modelling </option>
                  <option value="FOODNUTR"> Foods and Nutrition </option>
                  <option value="FRENCH"> French </option>
                  <option value="GEOGRAPH"> Geography </option>
                  <option value="GEOLOGY"> Geology </option>
                  <option value="GERMAN"> German </option>
                  <option value="GGB"> Global Great Books </option>
                  <option value="GLE"> Governance, Leadership & Ethics </option>
                  <option value="GREEK"> Greek </option>
                  <option value="GPE"> Green Process Engineering </option>
                  <option value="HEALTSCI"> Health Sciences </option>
                  <option value="HEBREW"> Hebrew </option>
                  <option value="HISTTHEO"> Historical Theology </option>
                  <option value="HISTORY"> History </option>
                  <option value="HISTSCI"> History of Science </option>
                  <option value="HOMILET"> Homiletics </option>
                  <option value="HUMANECO"> Human Ecology </option>
                  <option value="HUMANRS"> Human Rights Studies </option>
                  <option value="INDIGSTU"> Indigenous Studies </option>
                  <option value="INTEGSCI"> Integrated Science </option>
                  <option value="ICC"> Intercultural Communications </option>
                  <option value="INTERDIS"> Interdisciplinary Studies </option>
                  <option value="INTREL"> International Relations </option>
                  <option value="ITALIAN"> Italian </option>
                  <option value="JAPANESE"> Japanese </option>
                  <option value="JEWISH"> Jewish Studies </option>
                  <option value="MTP-BRJR"> Journalism-Broadcasting Fanshawe </option>
                  <option value="KINESIOL"> Kinesiology </option>
                  <option value="LATIN"> Latin </option>
                  <option value="LAW"> Law </option>
                  <option value="LS"> Leadership Studies </option>
                  <option value="LINGUIST"> Linguistics </option>
                  <option value="LITURST"> Liturgical Studies </option>
                  <option value="LITURGIC"> Liturgics </option>
                  <option value="MOS"> Management & Organizational Studies</option>
                  <option value="MTP-MKTG"> Marketing - Fanshawe </option>
                  <option value="MATH"> Mathematics </option>
                  <option value="MME"> Mech & Materials Engineering </option>
                  <option value="MSE"> Mechatronic Systems Engineering </option>
                  <option value="MIT"> Media, Information & Technoculture </option>
                  <option value="MEDBIO"> Medical Biophysics </option>
                  <option value="MEDHINFO"> Medical Health Informatics</option>
                  <option value="MEDSCIEN"> Medical Sciences </option>
                  <option value="MEDIEVAL"> Medieval Studies </option>
                  <option value="MICROIMM"> Microbiology & Immunology </option>
                  <option value="MORALTHE"> Moral Theology </option>
                  <option value="MTP-MMED"> Multimed Design & Prod Fanshawe </option>
                  <option value="MCS"> Museum and Curatorial Studies </option>
                  <option value="MUSIC"> Music </option>
                  <option value="NEURO"> Neuroscience </option>
                  <option value="NURSING"> Nursing </option>
                  <option value="ONEHEALT"> One Health </option>
                  <option value="PASTTHEO"> Pastoral Theology </option>
                  <option value="PATHOL"> Pathology </option>
                  <option value="PERSIAN"> Persian </option>
                  <option value="PHARM"> Pharmacology </option>
                  <option value="PHILST"> Philosophical Studies </option>
                  <option value="PHILOSOP"> Philosophy </option>
                  <option value="PHYSICS"> Physics </option>
                  <option value="PHYSIOL"> Physiology </option>
                  <option value="PHYSPHRM"> Physiology and Pharmacology </option>
                  <option value="POLISCI"> Political Science </option>
                  <option value="PPE"> Politics, Philosophy, Economics </option>
                  <option value="PSYCHOL"> Psychology </option>
                  <option value="REHABSCI"> Rehabilitation Sciences </option>
                  <option value="RELEDUC"> Religious Education </option>
                  <option value="RELSTUD"> Religious Studies </option>
                  <option value="SACRTHEO"> Sacramental Theology </option>
                  <option value="SCHOLARS"> Scholars Electives </option>
                  <option value="SCIENCE"> Science </option>
                  <option value="SOCLJUST"> Social Justice & Peace Studies </option>
                  <option value="SOCSCI"> Social Science </option>
                  <option value="SOCWORK"> Social Work </option>
                  <option value="SOCIOLOG"> Sociology </option>
                  <option value="SE"> Software Engineering </option>
                  <option value="SPANISH"> Spanish </option>
                  <option value="SPEECH"> Speech </option>
                  <option value="SPIRTHEO"> Spiritual Theology </option>
                  <option value="STATS"> Statistical Sciences </option>
                  <option value="SA"> Studio Art </option>
                  <option value="SYSTHEO"> Systematic Theology </option>
                  <option value="THANAT"> Thanatology </option>
                  <option value="THEATRE"> Theatre Studies </option>
                  <option value="THEOETH"> Theological Ethics </option>
                  <option value="THEOLST"> Theological Studies </option>
                  <option value="THESIS"> Thesis </option>
                  <option value="TJ"> Transitional Justice </option>
                  <option value="WTC"> Western Thought & Civilization </option>
                  <option value="WOMENST"> Women's Studies </option>
                  <option value="WORLDLIT"> World Literatures and Cultures </option>
                  <option value="WRITING"> Writing </option>
                </select>
                <div class="invalid-feedback">
                  Course selection required.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="courseNum" style="color:#39266F">Class number*  <a href="class-number.png" target="_blank">What's this?</a></label>
                <input type="number" class="form-control" id="courseNum" name="courseNum" min="1000" max="99999" placeholder="eg. 1001" required>
                <!--<input type="text" class="form-control" id="courseNum" minlength="4" maxlength="5" placeholder="eg. 1001" required is-invalid>-->
                <div class="invalid-feedback">
                  Valid course code required.
                </div>
              </div>
            </div>
            <!--<div class="py-1 text-center">
              <p  style="margin-top: 2em">Please make sure you have entered the correct information so that we can notify you!</p>
              </div>-->
            <button style="margin-top: 2em" class="btn btn-secondary btn-lg btn-block" name="submit" type="submit">Submit</button>
          </form>
        </div>
      </div>
      <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">UWO Course Notifier (:</p>
        <ul class="list-inline">
          <li class="list-inline-item"><a href="mailto:coursenotifier@gmail.com">Contact</a></li>
          <li class="list-inline-item">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
              <input type="submit" class="link-button" value="Donate" title="PayPal - The safer, easier way to pay online!" />
              <input type="hidden" name="cmd" value="_donations" />
              <input type="hidden" name="business" value="MCE9Y837APC8A" />
              <input type="hidden" name="item_name" value="Thanks for supporting us!" />
              <input type="hidden" name="currency_code" value="CAD" />
            </form>
          </li>
        </ul>
      </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
    <script src="validation.js"></script>
  </body>
</html>