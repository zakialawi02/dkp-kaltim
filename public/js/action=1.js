$(document).ready(function () {
  $("#username").keyup(function (e) {
    let username = $("#username").val();
    console.log(username);
    if (username.indexOf(" ") !== -1) {
      $(".usernameFail").removeClass("d-none");
      $("#username").addClass("is-invalid");
      $(".kirim").attr("disabled", true);
    } else {
      $(".usernameFail").addClass("d-none");
      $("#username").removeClass("is-invalid");
      $(".kirim").attr("disabled", false);
    }
  });

  function validatePassword() {
    const password = $("#password").val();
    const pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (pattern.test(password)) {
      $("#password").removeClass("is-invalid");
      $("#passwordHelp").text("");
      return true;
    } else {
      $("#password").addClass("is-invalid");
      $("#passwordHelp").text(
        "Password harus minimal 8 karakter dan memiliki kombinasi huruf dan angka."
      );
      return false;
    }
  }
  $(".kirim").click(function (event) {
    if (!validatePassword()) {
      event.preventDefault();
    }
  });
});
