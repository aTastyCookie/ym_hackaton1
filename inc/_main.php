<?php
if(count($_POST)){
	include "BarcodeQR.php";
	$qr = new BarcodeQR();
	
	if(isset($_POST['ymnumber']) && isset($_POST['summ']) && isset($_POST['forwhat'])){
		$qr->ympay($_POST['ymnumber'], $_POST['summ'], $_POST['forwhat']);
	}elseif (isset($_POST['emailtopay']) && isset($_POST['summ']) && isset($_POST['forwhat'])){
		$qr->ymkassa($_POST['emailtopay'], $_POST['summ'], $_POST['forwhat']);
	}
}
$size = array('1'=>'58','2'=>'87','3'=>'116','4'=>'174','5'=>'232','6'=>'290');
?>
<div class="container" style="margin-top:40px">	
	<div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a href="#main"><i class="fa fa-money"></i> О проекте с двумя API</a></li>
              <li ><a href="#ympay"><i class="fa fa-money"></i> Яндекс.Деньги p2p</a></li>
              <li><a href="#ymkassa"><i class="fa fa-money"></i> Яндекс.Касса</a></li>
            </ul> 
        </div>
    </div>
	<div class="row">
        <div class="col-md-12">
                <div class="tab-content">
				
				                  <div class="tab-pane active" id="main">
				<div class="row">
					<div class="col-md-12">
<div class="col-md-12">
           
        <div class="panel panel-default">
          <div class="panel-heading">Цель проекта:</div>
          <div class="panel-body">
            <p>Сделать хороший и простой продукт как для физических лиц, так и для юридических лиц для приема платежей</p>
            <br>
            <p><b>Для физлиц</b>: генерация куркода, который приведет прямиком к оптате зарнее подготовленого платежа</p>
            <p><b>Для юрлиц:</b> формирование счета на оптату, чтобы пользователь мог быстро и легко оплатить его любым удобным для него способом, просто кликнув на иконку в письме</p>
          </div>
        </div>
           </div>
		   </div>
                  </div>
                  </div>
				
				
				
                  <div class="tab-pane" id="ympay">
				<div class="row">
					<div class="col-md-8">
                    <form action="" method="post" class="form-horizontal">
	                   <input class="form-control" type="hidden" name="id" value="ympay">
	                  <div class="form-group">
                    <label class="col-md-2 control-label" for="ymnumber">Номер ЯД кошелька</label>
		                <div class="col-md-10">
        		          	<input class="form-control" type="text" name="ymnumber" value="<?php if(isset($_POST['ymnumber'])) echo $_POST['ymnumber'];?>" required="required">
                        </div>
                    </div>  
                    <div class="form-group">
                    <label class="col-md-2 control-label" for="summ">Сумма к оплате</label>
		                <div class="col-md-10">      
                    	<input class="form-control" type="summ" name="summ" value="<?php if(isset($_POST['summ'])) echo $_POST['summ'];?>" required="required">
                     </div>
                    </div> 
                    <div class="form-group">
                    <label class="col-md-2 control-label" for="forwhat">За что платить будут?</label>
		                <div class="col-md-10">      
                    	<input class="form-control" type="forwhat" name="forwhat" value="<?php if(isset($_POST['forwhat'])) echo $_POST['forwhat'];?>" required="required">
                     </div>
                    </div> 
                    <div class="form-group">
                    <label class="col-md-2 control-label" for="img_size">Размер куркода  (px)</label>
		                <div class="col-md-2">  
                       	<select class="form-control" name="img_size">
                        	<?php foreach($size as $k=>$v){?>
                            	<option value="<?php echo $v?>" <?php if(isset($_POST['img_size']) && $_POST['img_size'] == $v){ echo "selected";}
								elseif(!isset($_POST['img_size']) && $k == 5){ echo "selected";}
								?>><?php echo $v?></option>
                            <?php }?>
                        </select>
                     </div>
                    </div>
                 <hr>   
                <div class="form-group">
					<div class="col-md-12">
	         			<button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-qrcode"></i> Создать куркод</button>
					</div>
        		</div>
   			 </form>
           </div>
        <div class="col-md-4">
        <?php if(count($_POST)){?> 
            <div class="panel panel-primary">
              <div class="panel-heading">Куркод для оплаты</div>
              <div class="panel-body">    
        	<?php 
			$img = "qrcode".time().".png";
			if(!isset($_POST['img_size'])) $_POST['img_size'] = 174;
			$qr->draw($_POST['img_size'], "img/".$img);?>
			<center><p><noscript><b>You have JavaScript turned off.</b> So this won't work. That is to be expected.</noscript><p><img src="img/<?php echo $img?>" width="<?php echo $_POST['img_size']?>" height="<?php echo $_POST['img_size']?>" class="img-thumbnail" alt="YMHctn" onClick="printme(event)"/></p></center>
			<div>
                    <div>
                    <div style="text-align:left; color:#000000"><b>Расшарить в соцсети</b></div>

					<p>
						<button class="social_share" data-type="vk" data-image="<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>">ВКонтакте</button>
						<button class="social_share" data-type="fb" data-image="<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>">Facebook</button>
						<button class="social_share" data-type="tw" data-image="<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>">Twitter</button>
						<button class="social_share" data-type="lj" data-image="<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>">LiveJournal</button>
						<button class="social_share" data-type="ok" data-image="<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>">Одноклассники</button>
						<button class="social_share" data-type="mr" data-image="<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>">Mail.Ru</button>
					</p>
					
                    <div style="text-align:left; color:#000000"><b>Ссылка</b></div>
                    <input class="form-control" type="text" class="span12" value="<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>" onclick="this.select();"></div>
					
                    <div>
                    <div style="text-align:left; color:#000000"><b>BBCode</b></div>
                    <input class="form-control" type="text" class="span12" value="[url=<?php echo $_SERVER['HTTP_REFERER']?>][img]<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>[/img][/url]" onclick="this.select();"></div>
                    <div>
                    <div style="text-align:left; color:#000000"><b>HTML</b></div>
                    <input class="form-control" type="text" class="span12" value="&lt;a href=&quot;<?php echo $_SERVER['HTTP_REFERER']?>&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;<?php echo $_SERVER['HTTP_REFERER']?>/img/<?php echo $img?>&quot; border=&quot;0&quot; alt=&quot;YMHctn&quot; /&gt;&lt;/a&gt;"  onclick="this.select();"></div>							
				</div>
            </div>
         </div>   
        <?php } ?>   
        </div>
                  </div>
                  </div>

                  <div class="tab-pane" id="ymkassa">
                    <form action="" method="post" class="form-horizontal">
                       <input class="form-control" type="hidden" name="id" value="ymkassa">
                      <div class="form-group">
                    <label class="col-md-2 control-label" for="emailtopay">email к оплате</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="emailtopay" value="<?php if(isset($_POST['emailtopay'])) echo $_POST['emailtopay'];?>" required="required">
                        </div>
                    </div>  
                    <div class="form-group">
                    <label class="col-md-2 control-label" for="summ">Сумма к оплате</label>
                        <div class="col-md-10">      
                        <input class="form-control" type="summ" name="summ" value="<?php if(isset($_POST['summ'])) echo $_POST['summ'];?>" required="required">
                     </div>
                    </div> 
                    <div class="form-group">
                    <label class="col-md-2 control-label" for="forwhat">За что платить будут?</label>
                        <div class="col-md-10">      
                        <input class="form-control" type="forwhat" name="forwhat" value="<?php if(isset($_POST['forwhat'])) echo $_POST['forwhat'];?>" required="required">
                     </div>
                    </div> 
                 <hr>   
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-envelope"></i> Выставить счет</button>
                    </div>
                </div>
             </form>
                  </div>


        </div>
        </div>
                 
                <script>
                  $(function () {
                    $('#myTab a').click(function (e) {
						 e.preventDefault();
	   					 $(this).tab('show');
					})
                  })
				  
				$(document).on('click', '.social_share', function(){
					Share.go(this);
				});
                </script>
				<script>
					function makepage(src)
					{
					return "<html>\n" +
					"<head>\n" +
					"<title>Temporary Printing Window</title>\n" +
					"<script>\n" +
					"function step1() {\n" +
					" setTimeout('step2()', 10);\n" +
					"}\n" +
					"function step2() {\n" +
					" window.print();\n" +
					" window.close();\n" +
					"}\n" +
					"</scr" + "ipt>\n" +
					"</head>\n" +
					"<body onLoad='step1()'>\n" +
					"<img src='" + src + "'/>\n" +
					"</body>\n" +
					"</html>\n";
					}
					function printme(evt)
					{
					if (!evt) {
					// Old IE
					evt = window.event;
					} 
					var image = evt.target;
					if (!image) {
					// Old IE
					image = window.event.srcElement;
					}
					src = image.src;
					link = "about:blank";
					var pw = window.open(link, "_new");
					pw.document.open();
					pw.document.write(makepage(src));
					pw.document.close();
					}
				</script>

	</div>
</div>    