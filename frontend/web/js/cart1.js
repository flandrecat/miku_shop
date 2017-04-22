/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
function totalPrice()
{
    var total = 0;
    $(".col5 span").each(function(){
        total += parseFloat($(this).text());
    });

    $("#total").text(total.toFixed(2));
}
$(function(){
	
	//减少
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		if (parseInt($(amount).val()) <= 1){
			alert("商品数量最少为1");
		} else{
			$(amount).val(parseInt($(amount).val()) - 1);
		}
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
	});

	//增加
	$(".add_num").click(function(){
		var amount = $(this).parent().find(".amount");
		var num = parseInt($(amount).val()) + 1;//增加的数量
		var tr = $(this).closest('tr');//找到tr
		var goods_id =tr.attr('data-goods-id');//找到goods_id
		console.log(goods_id);
		//csrf
		var token = $(this).closest('tbody').attr('csrf');
		//发起ajax请求
		$.post('/cart/ajax?filter=modify',{goods_id:goods_id,num:num,'_csrf-frontend':token},function (data) {
			if(data == 'success'){
				//设置值
				$(amount).val(num);
				//小计
				var subtotal = parseFloat(tr.find(".col3 span").text()) * parseInt($(amount).val());
				tr.find(".col5 span").text(subtotal.toFixed(2));
				//总计金额
				var total = 0;
				$(".col5 span").each(function(){
					total += parseFloat($(this).text());
				});
				$("#total").text(total.toFixed(2));
			}
        });
	});

	//直接输入
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(this).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));

	});
});