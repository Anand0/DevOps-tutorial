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
          //   $("td:nth-child(1)").hide();
          var column = $("td:nth-child(1)");
          $(column).hide();
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

    var $row = $(this).closest("tr"); // Find the row
    var $ticketId = $row.find(".nr").text(); // Find the text

    $.ajax({
      url: "data.php?ticket_id=" + $ticketId,
      method: "POST",

      success: function(data) {
        // alert(data);
        $("textarea").val(data);
        $("#viewModal").show();
      }
    });
  });

  $("#more_btn").click(function() {
    // alert("hello");
    initalVal = parseInt(finalVal);
    finalVal = parseInt(finalVal) + parseInt(50);

    console.log("inital Count =", initalVal);
    console.log("final log = ", finalVal);
  });
  $(document).on("click", "#close-mod", function() {
    $("#viewModal").hide();
  });
});
