// Example starter JavaScript for disabling form submissions if there are invalid fields
(function validate() {
  'use strict'

  window.addEventListener('load', function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation')

    // Loop over them and prevent submission
    Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {

        if (form.checkValidity() === false) {
          event.preventDefault()
          event.stopPropagation()
          form.classList.add('was-validated')
        } else {
          //alert("Thanks for using MyCourseIsFull! We'll notify you when a spot in your course opens up.");
          return true; 
        }
      }, false)
    })
    
  }, false)

}())