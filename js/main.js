$(document).ready(function() {
  var initalVal = 0;
  var finalVal = 50;
  // $("#more_btn").hide();
  $("#search-submit").click(function() {
    $("#loader").show();
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    var str = $(".search_txt").val();
    // var str1 = $(".ticket_txt").val();
    /*  if (str1.trim() && str.trim()) {
      $("#loader").hide();
      // $("#more_btn").show();
      alert("please enter any one text");
      return;
    }*/
    if (str.trim()) {
      $.ajax({
        url: "data.php?user=" + str,
        method: "POST",

        success: function(data) {
          $("#loader").hide();
          // $("#more_btn").show();
          $("#order_table").html(data);
        }
      });
    } else if (str1.trim()) {
      $.ajax({
        url: "data.php?ticket_id=" + str1,
        method: "POST",

        success: function(data) {
          $("#loader").hide();
          // $("#more_btn").show();
          $("#order_table").html(data);
          // $(".header-lft").text("Click(s) Count");
          // $("#viewModal").show();
        }
      });
    } else {
      $("#loader").hide();
      alert("please enter any one text");
    }
  });

  $(document).on("click", "#table tr", function() {
    // alert(2);
  });

  $("#more_btn").click(function() {
    // alert("hello");
    initalVal = parseInt(finalVal);
    finalVal = parseInt(finalVal) + parseInt(50);

    console.log("inital Count =", initalVal);
    console.log("final log = ", finalVal);
  });
});
