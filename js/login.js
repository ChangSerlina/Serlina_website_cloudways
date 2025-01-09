// 登入函數
function login2() {
    $("#register").hide();  // 不顯示註冊頁面
    $("#login").show();     // 顯示登入頁面

    //如果密碼連續輸入錯誤5次要擋
    var loginChecked = 0;
    if (loginChecked == 0) {
        loginChecked = 1;
        $.ajax({
            type: "POST",
            url: "member_action.php?action=memberLogin",
            data: $("#memberForm").serialize(),
            success: function (response) {
                if (response.trim() == "登入成功") {
                    location.href = "index.php";
                } else {
                    alert("帳號或密碼錯誤");
                    console.log(response.trim());
                    $("#login").html("<p>請輸入正確的帳號或密碼</p><br><p>若您還不是本站會員，請先註冊，謝謝您。</p>");
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }
}

// 註冊函數
function register() {
    //取得帳號.密碼
    var email = $("#email2").val();
    var pwd = $("#pwd").val();

    if (email == "") {
        alert("請輸入email");
        $('#email2').focus();
        return
    }

    if (pwd == "" || pwd.length < 6 || pwd.length > 12) {
        alert("請輸入6~12位數密碼");
        $('#pwd').focus();
        return
    }

    //先檢查帳號是否已被註冊，再新增會員
    $.ajax({
        type: "POST",
        url: "member_action.php?action=checkMember",
        data: $("#memberForm").serialize(),
        success: function (response) {
            if (response.trim() == "1") {
                alert("此帳號已被使用");
            } else {
                addMember();
                // 如果驗證成功，手動提交表單
                $('#memberForm').submit();

                $("#register").show();  // 顯示
                $("#login").hide();     // 不顯示
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + error);
        }
    });
}

function addMember() {
    $.ajax({
        type: "POST",
        url: "member_action.php?action=addMember",
        data: $("#memberForm").serialize(),
        success: function (response) {
            if (response.trim() == "failed") {
                alert("會員新增失敗");
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + error);
        }
    });
}

function modifyMember() {
    $.ajax({
        type: "POST",
        url: "member_action.php?action=updateMember",
        data: $("#memberDetailForm").serialize(),
        success: function (response) {
            if (response.trim() == "failed") {
                alert("修改會員資料失敗");
            } else {
                location.href = "index.php";
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error: ' + status + error);
        }
    });
}