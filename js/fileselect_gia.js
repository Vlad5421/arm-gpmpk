var els = ["zayav", "zayav_str2", "svidoroj", "vipiska_str1", "vipiska_str2", "harkt_str1", "harkt_str2", "harkt_str3", "harkt_str4", "harkt_str5", "med_zakl_gia_str1", "med_zakl_gia_str2", "prikaz_gia", "predzakl_gia", "mse_str1", "mse_str2"];
var el;
for (let i = 0; i < els.length; i++) {
  el = els[i];
  document.getElementById(el).addEventListener('change', function (e) {
    const that = e.target;
    var fReader = new FileReader();
    fReader.readAsDataURL(that.files[0]);
    fReader.onloadend = function (event) {
      that.nextElementSibling.src = event.target.result;
    }
  });
}