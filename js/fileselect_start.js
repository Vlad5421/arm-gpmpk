document.getElementById('zayav').addEventListener('change', selectZayav, false);
function selectZayav(){
var fReader = new FileReader();
fReader.readAsDataURL(zayav.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('zayavImg');
    img.style="height: 110px";
    img.src = event.target.result;

}
}
document.getElementById('svidoroj').addEventListener('change', selectSvidoroj);
function selectSvidoroj(){
var fReader = new FileReader();
fReader.readAsDataURL(svidoroj.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('svidorojImg');
    img.style="height: 110px";
    img.src = event.target.result;
}
}
document.getElementById('pasport_str1').addEventListener('change', selectPasport_str1);
function selectPasport_str1(){
var fReader = new FileReader();
fReader.readAsDataURL(pasport_str1.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('pasport_str1Img');
    img.style="height: 110px";
    img.src = event.target.result;
}
}
document.getElementById('pasport_str2').addEventListener('change', selectPasport_str2);
function selectPasport_str2(){
var fReader = new FileReader();
fReader.readAsDataURL(pasport_str2.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('pasport_str2Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('napravlenie').addEventListener('change', selectNapravlenie);
function selectNapravlenie(){
var fReader = new FileReader();
fReader.readAsDataURL(napravlenie.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('napravlenieImg');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('vipiska_str1').addEventListener('change', selectVipiska_str1);
function selectVipiska_str1(){
var fReader = new FileReader();
fReader.readAsDataURL(vipiska_str1.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('vipiska_str1Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('vipiska_str2').addEventListener('change', selectVipiska_str2);
function selectVipiska_str2(){
var fReader = new FileReader();
fReader.readAsDataURL(vipiska_str2.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('vipiska_str2Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('harkt_str1').addEventListener('change', selectHarkt_str1);
function selectHarkt_str1(){
var fReader = new FileReader();
fReader.readAsDataURL(harkt_str1.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('harkt_str1Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('harkt_str2').addEventListener('change', selectHarkt_str2);
function selectHarkt_str2(){
var fReader = new FileReader();
fReader.readAsDataURL(harkt_str2.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('harkt_str2Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('harkt_str3').addEventListener('change', selectHarkt_str3);
function selectHarkt_str3(){
var fReader = new FileReader();
fReader.readAsDataURL(harkt_str3.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('harkt_str3Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('konsil_str1').addEventListener('change', selectKonsil_str1);
function selectKonsil_str1(){
var fReader = new FileReader();
fReader.readAsDataURL(konsil_str1.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('konsil_str1Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('konsil_str2').addEventListener('change', selectKonsil_str2);
function selectKonsil_str2(){
var fReader = new FileReader();
fReader.readAsDataURL(konsil_str2.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('konsil_str2Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('konsil_str3').addEventListener('change', selectKonsil_str3);
function selectKonsil_str3(){
var fReader = new FileReader();
fReader.readAsDataURL(konsil_str3.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('konsil_str3Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('zaklpredpmpk_str1').addEventListener('change', selectZaklpredpmpk_str1);
function selectZaklpredpmpk_str1(){
var fReader = new FileReader();
fReader.readAsDataURL(zaklpredpmpk_str1.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('zaklpredpmpk_str1Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('zaklpredpmpk_str2').addEventListener('change', selectZaklpredpmpk_str2);
function selectZaklpredpmpk_str2(){
var fReader = new FileReader();
fReader.readAsDataURL(zaklpredpmpk_str2.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('zaklpredpmpk_str2Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('mse_str1').addEventListener('change', selectMse_str1);
function selectMse_str1(){
var fReader = new FileReader();
fReader.readAsDataURL(mse_str1.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('mse_str1Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}
document.getElementById('mse_str2').addEventListener('change', selectMse_str2);
function selectMse_str2(){
var fReader = new FileReader();
fReader.readAsDataURL(mse_str2.files[0]);
fReader.onloadend = function(event){
    var img = document.getElementById('mse_str2Img');
    img.style='height: 110px';
    img.src = event.target.result;
}
}