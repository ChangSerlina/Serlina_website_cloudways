function myFunction() {
  var x = document.getElementById("topnav");
  if (x.className === "topnav") {
    x.className += " responsive";
    document.getElementById("headcontainer").className = "col-sm-12";
    document.getElementById("search").style.display = "block";
    document.getElementById("a_nav").style.display = "block";
    document.getElementById("title").className = "col-sm-12";
  } else {
    x.className = "topnav";
    document.getElementById("headcontainer").className = "headcontainer col-9";
    document.getElementById("search").style.display = "none";
    document.getElementById("a_nav").style.display = "none";
    document.getElementById("title").className = "col-2 col-sm-8";
  }
}

/**
 * 會員按鈕
 */
function memberButton() {
  const memberList = document.getElementById("memberList");
  memberList.classList.toggle("show");
}

function redirecIndex() {
  setTimeout(function() {
      window.location.href = "./index.php"; // 替換為你的目標網址
  }, 3000); // 3000毫秒等於3秒
}

//取得現在年度
document.addEventListener("DOMContentLoaded", function () {
  var currentYear = new Date().getFullYear();
  document.getElementById("currentYear").textContent = currentYear;
});
