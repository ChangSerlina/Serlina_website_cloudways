// 左側 (上方)導覽列顯示
function mya1_3(){
    document.getElementById('2023').classList.add('myActive');  
    document.getElementById('2021').classList.remove('myActive');  
    document.getElementById('2019').classList.remove('myActive');  
    document.getElementById('2023_n').classList.add('myActive');  
    document.getElementById('2021_n').classList.remove('myActive');  
    document.getElementById('2019_n').classList.remove('myActive');  
    document.getElementById('country_2023').style.display="block"; 
    document.getElementById('country_2021').style.display="none"; 
    document.getElementById('country_2019').style.display="none"; 
    document.getElementById('tab1_3').classList.add('myActive');    
}
function mya1_2(){
    document.getElementById('2023').classList.remove('myActive');  
    document.getElementById('2021').classList.add('myActive');  
    document.getElementById('2019').classList.remove('myActive');  
    document.getElementById('2023_n').classList.remove('myActive');  
    document.getElementById('2021_n').classList.add('myActive');  
    document.getElementById('2019_n').classList.remove('myActive');  
    document.getElementById('country_2023').style.display="none"; 
    document.getElementById('country_2021').style.display="block"; 
    document.getElementById('country_2019').style.display="none"; 
    document.getElementById('tab1_2').classList.add('myActive');   
}
function mya1_1(){
    document.getElementById('2023').classList.remove('myActive');  
    document.getElementById('2021').classList.remove('myActive');  
    document.getElementById('2019').classList.add('myActive');  
    document.getElementById('2023_n').classList.remove('myActive');  
    document.getElementById('2021_n').classList.remove('myActive');  
    document.getElementById('2019_n').classList.add('myActive');  
    document.getElementById('country_2023').style.display="none"; 
    document.getElementById('country_2021').style.display="none"; 
    document.getElementById('country_2019').style.display="block"; 
}

// 右側內文顯示
// 內文2023
function myc1(){
    document.getElementById('c1').style.display="block";
    document.getElementById('tab1_3').classList.add('myActive');  
}
// 內文2021
function myb1(){
    document.getElementById('b1').style.display="block";
    document.getElementById('tab1_2').classList.add('myActive');  
}

// 內文2019
document.getElementById('tab1').classList.add('myActive');

function mya1(){
    document.getElementById('2019').classList.add('myActive');                 // 套用myActive
    document.getElementById('tab1').classList.add('myActive');                 // 套用myActive
    document.getElementById('tab2').classList.remove('myActive');              // 移除myActive
    document.getElementById('tab3').classList.remove('myActive');              // 移除myActive
    document.getElementById('a1').style.display="block";                      // 顯示
    document.getElementById('a2').style.display="none";                       // 不顯示
    document.getElementById('a3').style.display="none";                       // 不顯示
}
function mya2(){
    document.getElementById('2019').classList.add('myActive');                 // 套用myActive
    document.getElementById('tab1').classList.remove('myActive');              // 移除myActive
    document.getElementById('tab2').classList.add('myActive');                 // 套用myActive
    document.getElementById('tab3').classList.remove('myActive');              // 移除myActive
    document.getElementById('a1').style.display="none";                      // 不顯示
    document.getElementById('a2').style.display="block";                       // 顯示
    document.getElementById('a3').style.display="none";                       // 不顯示
}
function mya3(){
    document.getElementById('2019').classList.add('myActive');                 // 套用myActive
    document.getElementById('tab1').classList.remove('myActive');                 // 移除myActive
    document.getElementById('tab2').classList.remove('myActive');              // 移除myActive
    document.getElementById('tab3').classList.add('myActive');              // 套用myActive
    document.getElementById('a1').style.display="none";                      // 不顯示
    document.getElementById('a2').style.display="none";                       // 不顯示
    document.getElementById('a3').style.display="block";                       // 顯示
}
