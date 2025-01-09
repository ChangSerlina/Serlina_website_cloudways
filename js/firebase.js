// 新增資料，會把舊資料取代
function t1() {
    var t1 = document.getElementById('t1').value
    if (t1 !== "") {
        firebase.database().ref('table').set({
            colume: t1
        });
        alert('資料新增成功');
        document.getElementById('t1').value = "";
    } else {
        alert('請輸入資料');
    }

};
// 查詢資料
function t2() {
    var t1 = document.getElementById('t1').value;
    var search = firebase.database().ref('table');
    if (t1 !== "") {
        search.on('value', (table) => {
            const data = table.val();
            console.log(data);
            document.getElementById('searchData').innerHTML = "查詢結果: " + JSON.stringify(data, null, 8);
        });
        document.getElementById('t3').disabled=false;
        document.getElementById('t4').disabled=false;
    }else{
        alert('請輸入資料');
    }

}

//刪除資料
function t3() {
    if (confirm("確認要刪除資料嗎 (危險!! 資料刪除後，無法復原)") == true) {
        firebase.database().ref('table').child('colume').set({
            colume: null
        });
    }
    document.getElementById('t1').value = "";
};

// 修改(更新)資料
function t4() {
    var t1 = document.getElementById('t1').value
    // A post entry.
    var postData = {
        colume: t1
    };

    // Get a key for a new Post.
    var newPostKey = firebase.database().ref().child('table').push().key;

    // Write the new post's data simultaneously in the posts list and the user's post list.
    var updates = {};
    updates['/table/' + newPostKey] = postData;
    updates['/user-posts/' + '1' + '/' + newPostKey] = postData;
    alert('資料修改成功');
    return firebase.database().ref().update(updates);
};


