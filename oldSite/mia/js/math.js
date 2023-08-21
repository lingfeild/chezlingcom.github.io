var x = {};

// a+b=?
x.A = function () {
  function a_plus_b() {
    var a = Math.floor(Math.random() * 21);
    var b = Math.floor(Math.random() * 21);
    d = a + b;

    if (d <= 20) {
      document.getElementById("a").innerHTML = a;
      document.getElementById("c_sign").innerHTML = "+";
      document.getElementById("b").innerHTML = b;
      document.getElementById("c").innerHTML = "?";
      document.getElementById("c").classList.add("q_mark");
    } else {
      a_plus_b();
    }
  }
  a_plus_b();
};

// a-b=?
x.B = function () {
  function a_minus_b() {
    var a = Math.floor(Math.random() * 21);
    var b = Math.floor(Math.random() * 21);
    d = a - b;

    if (a >= b) {
      document.getElementById("a").innerHTML = a;
      document.getElementById("c_sign").innerHTML = "-";
      document.getElementById("b").innerHTML = b;
      document.getElementById("c").innerHTML = "?";
      document.getElementById("c").classList.add("q_mark");
    } else {
      a_minus_b();
    }
  }
  a_minus_b();
};

// ?+b=c
x.C = function () {
  function which_plus_b() {
    var b = Math.floor(Math.random() * 21);
    var c = Math.floor(Math.random() * 21);
    d = c - b;

    if (c >= b) {
      document.getElementById("a").innerHTML = "?";
      document.getElementById("a").classList.add("q_mark");
      document.getElementById("c_sign").innerHTML = "+";
      document.getElementById("b").innerHTML = b;
      document.getElementById("c").innerHTML = c;
    } else {
      which_plus_b();
    }
  }
  which_plus_b();
};

// ?-b=c
x.D = function () {
  function which_minus_b() {
    var b = Math.floor(Math.random() * 21);
    var c = Math.floor(Math.random() * 21);
    d = b + c;

    if (d <= 20) {
      document.getElementById("a").innerHTML = "?";
      document.getElementById("a").classList.add("q_mark");
      document.getElementById("c_sign").innerHTML = "-";
      document.getElementById("b").innerHTML = b;
      document.getElementById("c").innerHTML = c;
    } else {
      which_minus_b();
    }
  }
  which_minus_b();
};

// a+?=c
x.E = function () {
  function a_plus_which() {
    var a = Math.floor(Math.random() * 21);
    var c = Math.floor(Math.random() * 21);
    d = c - a;

    if (c >= a) {
      document.getElementById("a").innerHTML = a;
      document.getElementById("c_sign").innerHTML = "+";
      document.getElementById("b").innerHTML = "?";
      document.getElementById("b").classList.add("q_mark");
      document.getElementById("c").innerHTML = c;
    } else {
      a_plus_which();
    }
  }
  a_plus_which();
};

// a-?=c
x.F = function () {
  function a_minus_which() {
    var a = Math.floor(Math.random() * 21);
    var c = Math.floor(Math.random() * 21);
    d = a - c;

    if (a >= c) {
      document.getElementById("a").innerHTML = a;
      document.getElementById("c_sign").innerHTML = "-";
      document.getElementById("b").innerHTML = "?";
      document.getElementById("b").classList.add("q_mark");
      document.getElementById("c").innerHTML = c;
    } else {
      a_minus_which();
    }
  }
  a_minus_which();
};

var i = 0;
for (var s in x) {
  x[i] = x[s];
  ++i;
}

x[Math.floor(Math.random() * 6)]();

// input from num pad 1.add numbers 2.delete numbers to "?"
function number_write(x) {
  var q_mark = document.getElementsByClassName("q_mark")[0];
  if (x >= 0 && x <= 9) {
    if (isNaN(q_mark.innerHTML)) {
      q_mark.innerHTML = 0;
    }
    q_mark.innerHTML = (q_mark.innerHTML * 10) + x;
  }
}

function number_c() {
  var q_mark = document.getElementsByClassName("q_mark")[0];
  if (q_mark.innerHTML !== "?" && q_mark.innerHTML !== "0") {
    var num = q_mark.innerHTML;
    var num1 = num % 10;
    num -= num1;
    num /= 10;
    if (num == 0) {
      q_mark.innerHTML = "?";
    }
    else {
      q_mark.innerHTML = num;
    }
  }
  else if (q_mark.innerHTML == "?" || q_mark.innerHTML == "0") {
    q_mark.innerHTML = "?";
  }
}


// Compare input value to the correct number
function test() {
  var q_mark = document.getElementsByClassName("q_mark")[0];
  var question = document.getElementById("question");
  var q_mark_inner = q_mark.innerHTML;

  if (parseInt(q_mark_inner) == d) {
    $("#next_btn").show();
    $("#go_btn").hide();
    q_mark.classList.remove("q_mark");
  } else if (q_mark_inner == "?") {
    q_mark.classList.add("flash", "animated");
    setTimeout(function () {
      q_mark.classList.remove("flash", "animated");
    }, 1000);
  } else {
    question.classList.add("hinge", "animated");
    setTimeout(function () {
      question.classList.remove("hinge", "animated");
    }, 2500);
  }
}

// change background
function change_bg() {
  var total_count = 192;

  var num = Math.ceil(Math.random() * total_count);
  if (num < 10) {
    my_num = "00" + String(num);
  }
  else if (num >= 10 && num < 100) {
    my_num = "0" + String(num);
  }
  else {
    my_num = num;
  }

  var img_path = "img/" + my_num + ".jpg";

  $("#header").css("background-image", "url(" + img_path + ")");
}

// Go next question
$('#next_btn').on('click', function () {
  //random operation
  x[Math.floor(Math.random() * 6)]();

  //hide next_btn, show go_btn
  $("#next_btn").hide();
  $("#go_btn").show();

  //change bg
  change_bg();
});


