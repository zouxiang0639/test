$(function () {'use strict';



	//加油享收益
	$(document).on("pageInit", "#page-index", function(e) {
		var bannerSwiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			paginationClickable: true,
			autoplay:5000,
			autoplayDisableOnInteraction:false
		});
		var productItemSwiper = new Swiper('.swiper-product-item', {
			slidesPerView: 3.1,
			paginationClickable: false,
			spaceBetween: 10
		});
			var productTagSwiper = new Swiper('.swiper-product-tag', {
			slidesPerView: 4.1,
			paginationClickable: true,
			spaceBetween: 10
		});
		});
	//首页

	//业务详情
	$(document).on("pageInit", "#biz-detail", function(e, id, page) {
		//充值金额
		intuppicker();
		//month picker

		//字符串转化为数组

		$("#month-picker").picker({

			toolbarTemplate: '<header class="bar bar-nav">\
     <button class="button button-link pull-right close-picker">确定</button>\
     <h1 class="title">请选择购买期限</h1>\
     </header>',
			cols: [
				{
					textAlign: 'center',
					values: $('#day').val().split(","),
					cssClass: 'picker-items-col-normal'
				}
			]
		});
	});


//业务页面
//swiper
	$(document).on("pageInit", "#page-biz", function(e) {
		var productTagSwiper = new Swiper('.swiper-discount-tag', {
		slidesPerView: 4,
		paginationClickable: true,
		spaceBetween: 10
		});


		//充值金额
		intuppicker();

	//price picker
	$("#input-picker").picker({
	  toolbarTemplate: '<header class="bar bar-nav">\
	  <button class="button button-link pull-right close-picker">确定</button>\
	  <h1 class="title">请选择金额</h1>\
	  </header>',
	  cols: [
		{
		  textAlign: 'center',
		  values: ['100', '200', '300', '500', '600', '800', '1000'],
		  cssClass: 'picker-items-col-normal'
		}
	  ]
	});



	//tab radio
	$('.tab-radio-item').click(function(){
	  var radioId = $(this).attr('name');
	  $('.tab-radio-item').removeClass('active') && $(this).addClass('active');
	});

	//tag radio
	$('.swiper-slide').click(function(){
	var radioId = $(this).attr('name');
	$('.swiper-slide .icon-tag').removeClass('active') && $(this).children('.icon-tag').addClass('active');
	});

	//filling radio
	$('.filling-tag').click(function(){
	$('.filling-tag-box .filling-tag').removeClass('active') && $(this).addClass('active');
	});
	// total
	$('input').change(function(){

	  var price=parseInt($('input[name="price"]:checked').attr('price'));
	  if (isNaN(price)){price=parseInt($('input[name="price"]').val().replace(/[^0-9]/ig,""));}
	  var months=parseInt($('input[name="goods"]:checked').attr('months')),
		  discount=parseFloat($('input[name="goods"]:checked').data('discount')),
		  stage_charge=parseFloat($('input[name="goods"]:checked').attr('stagecharge')),
		  total_original=stage_charge==0 ? price :price * months,
		  total_reduction=(total_original*discount).toFixed(2),
		  total_saving=total_original - total_reduction,
		  monthpay_now= stage_charge==0 ? "即时充值"+price+"元" : price+"元/月*"+months+"个月 = "+total_original+"元";

	  $('#total-original').text(total_original);
	  $('#total-reduction').text(total_reduction);
	  $('#total-saving').text(total_saving);
	  $('#total-monpay').text(price);
	  $('#total-monpay').text(monthpay_now);
	  $('#total-onemoney').text(price);

	});

	});

//用户注册
$(document).on("pageInit", "#user-register", function(e, id, page) {
  var $content = $(page).find('.content');
  $content.on('click','.getSms',function () {
	$.alert('验证码发送成功，请查收');
  });
});




//price picker
$("#input-picker").picker({
  toolbarTemplate: '<header class="bar bar-nav">\
  <button class="button button-link pull-right close-picker">确定</button>\
  <h1 class="title">请选择金额</h1>\
  </header>',
  cols: [
	{
	  textAlign: 'center',
	  values: ['100', '200', '300', '500', '1000', '2000', '3000'],
	  cssClass: 'picker-items-col-normal'
	}
  ]
});






	//帐户设置

$(document).on("pageInit", "#user-setting", function(e) {
	var province,city,district,obj;
	obj         = $('#city-picker');
	province    = obj.attr('province');
	city        = obj.attr('city');
	district    = obj.attr('district');
	obj.cityPicker({
		value: [province, city,district]
	});
});
  
//银行卡
$(document).on("pageInit", "#user-safe-bank", function(e) {
//bank picker
$("#bank-name").picker({
	
  toolbarTemplate: '<header class="bar bar-nav">\
  <button class="button button-link pull-right close-picker">确定</button>\
  <h1 class="title">请选择金额</h1>\
  </header>',
  cols: [
	{
	  textAlign: 'center',
	  values: ['工商银行', '农业银行', '建设银行',  '中国银行', '浦发银行','招商银行', '邮政银行'],
	  cssClass: 'picker-items-col-normal'
	}
  ]
});
});
  
$.init();});




//输入框规则
function intuppicker(){
	//numbox    油卡价格输入框
	$('.text-center').blur(function(){
		var num = $(this).val();

		if(parseInt(num)!=num || num < 100){
			$(this).val(100);
			$(this).trigger("change");
			return false;
		}

		if(num > 5000){
			$(this).val(5000);
			$(this).trigger("change");
			return false;
		}

		var g = /\./;
		if(g.test(num/100)){
			$(this).val((parseInt(num/100)+1)*100);
			$(this).trigger("change");
			return false;
		}
	});

	//输入框规则
	$('.numbox-minus').click(function(){
		var i =$('input[name="price"]'),
				iVal=parseInt(i.val()),


				mixVal=100;
		if (iVal > mixVal){i.val(iVal-100)}; i.trigger("change");});

	$('.numbox-plus').click(function(){

		var i =$('input[name="price"]'),
				iVal=parseInt(i.val()),
				maxVal=5000;

		if (iVal < maxVal){i.val(iVal+100)};i.trigger("change");});
}


function confir($title,confirmUrl,cancelUrl){
	$.confirm($title,
		function () {
			window.location.replace(confirmUrl);
		},
		function () {
			if(cancelUrl == false){

			}else if(cancelUrl==undefined){
				window.history.go(-1);
			}else{
				window.location.replace(cancelUrl);
			}
		}
	);
}