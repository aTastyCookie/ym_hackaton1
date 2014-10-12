<?php
/**
 * BarcodeQR - Code QR Barcode Image Generator (PNG)
 *
 * @package BarcodeQR
 * @category BarcodeQR
 * @name BarcodeQR
 * @version 1.0
 * @author Shay Anderson 05.11
 * @link http://www.shayanderson.com/php/php-qr-code-generator-class.htm
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * This is free software and is distributed WITHOUT ANY WARRANTY
 */
final class BarcodeQR {
	/**
	 * Chart API URL
	 */
	const API_CHART_URL = "http://chart.apis.google.com/chart";

	/**
	 * Code data
	 *
	 * @var string $_data
	 */
	private $_data;

	/**
	 * ympay code
	 *
	 * @param string $ymnumber
	 * @param string $summ
	 * @param string $forwhat
	 */
	public function ympay($ymnumber = null, $summ = null, $forwhat = null) {
	
		$url = "money.yandex.ru/embed/small.xml?account={$ymnumber}&quickpay=small&yamoney-payment-type=on&button-text=01&button-size=l&button-color=orange&targets='.$forwhat.'&default-sum='.$summ.'&fio=on&mail=on&successURL=";
		$this->_data = preg_match("#^https?\:\/\/#", $url) ? $url : "https://{$url}";	
		
	}	

	/**
	 * Generate QR code image
	 *
	 * @param int $size
	 * @param string $filename
	 * @return bool
	 */
	public function draw($size = 150, $filename = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_CHART_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->_data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$img = curl_exec($ch);
		curl_close($ch);

		if($img) {
			if($filename) {
				if(!preg_match("#\.png$#i", $filename)) {
					$filename .= ".png";
				}
				
				return file_put_contents($filename, $img);
			} else {
				header("Content-type: image/png");
				print $img;
				return true;
			}
		}

		return false;
	}

	/**
	 * ympay code
	 *
	 * @param string $ymkassa
	 * @param string $summ
	 * @param string $forwhat
	 */

	public function ymkassa($emailtopay = null, $summ = null, $forwhat = null) {
		
		$to  = "{$emailtopay}" ; 
		$subject = "Оплата {$forwhat}"; 
		$message = ' 
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<body style="margin:0; padding:0;">
				<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;background-color:#F8F8F8;background-image: url(https://paybylink.ru/invoice/assets/img/email_template/bg_texture.png);" align="center">
					<tr>
						<td>
							<table cellpadding="0" cellspacing="0" width="640" style="border-collapse:collapse;" align="center">
								<tr><td height="60"/></tr>
								<tr>
									<td>
										<table cellpadding="0" cellspacing="0" width="640" style="border-collapse: collapse;">
											<tr>
												<td width="5"/>
												<td>
													<table cellpadding="0" cellspacing="0" width="632" style="border-collapse: collapse;">
														<tr>
															<td height="1" bgcolor="#E7E7E7" colspan="3"/>
														</tr>
														<tr>
															<td width="1" bgcolor="#E7E7E7"/>
															<td bgcolor="#FFFFFF" style="padding-top:30px;padding-right:0px;padding-bottom:20px;padding-left:0px;">
																<table cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
																	<tr>
																		<td colspan="3" align="center">
																			<!--<h1 style="margin-top:0;margin-bottom:20px;font-weight:normal;font-family:Arial;font-size:20px;color:#000000;">
																				К оплате: '.$summ.'
																			</h1>-->
																		</td>
																	</tr>
																	<tr>
																		<td width="100"/>
																		<td width="420">
																			<p style="color:#444444;font-family:Arial;font-size:14px;line-height:19px;margin-top:0;margin-bottom:8px;">Здравствуйте, '.$emailtopay.'</p>
																			<p style="color:#444444;font-family:Arial;font-size:14px;line-height:19px;margin-top:0;margin-bottom:8px;">
																				<b>Оплптите, пожалуйста:</b>
																				'.$forwhat.'
																			</p>
																		</td>
																		<td width="100"/>
																	</tr>
																	<tr>
																		<td width="630" colspan="3">
																			<p style="text-align: center;margin-top:45px">
																				<img width="630" height="3" alt="" src="https://paybylink.ru/invoice/assets/img/email_template/m_separator.png">
																			</p>
																		</td>
																	</tr>
																	<tr>
																		<td colspan="3" align="center">
																			<h1 style="margin-top:30;margin-bottom:30px;font-weight:normal;font-family:Arial;font-size:20px;color:#000000;">
																				Cумма: '.$summ.'
																			</h1>
																			<p>Выберите удобный для вас способ оплаты</p>
																			<p style="text-align: center;margin-top:20px">
																				<a href="https://money.yandex.ru/eshop.xml?ShopID=666&scid=999&CustomerNumber='.$forwhat.'&customerEmail='.$emailtopay.'&paymentType=AC&Sum='.$summ.'&cps_email='.$emailtopay.'" title="Банковской картой" target="_blank"><img width="299" height="50" alt="" src="https://paybylink.ru/invoice/assets/img/email_template/cards.png"></a>
																			</p>
																			<p style="text-align: center;margin-top:20px">
																				<a href="https://money.yandex.ru/eshop.xml?ShopID=666&scid=999&CustomerNumber='.$forwhat.'&customerEmail='.$emailtopay.'&paymentType=PC&Sum='.$summ.'&cps_email='.$emailtopay.'" title="С помощью Яндекс.Денег" target="_blank"><img width="299" height="50" alt="" src="https://paybylink.ru/invoice/assets/img/email_template/yamoney.png"></a>
																			</p>
																			<p style="text-align: center;margin-top:20px">
																				<a href="https://money.yandex.ru/eshop.xml?ShopID=666&scid=999&CustomerNumber='.$forwhat.'&customerEmail='.$emailtopay.'&paymentType=MC&Sum='.$summ.'&cps_email='.$emailtopay.'" title="С мобильного телефона" target="_blank"><img width="299" height="50" alt="" src="https://paybylink.ru/invoice/assets/img/email_template/mobile.png"></a>
																			</p>
																			<p style="text-align: center;margin-top:20px">
																				<a href="https://money.yandex.ru/eshop.xml?ShopID=666&scid=999&CustomerNumber='.$forwhat.'&customerEmail='.$emailtopay.'&paymentType=GP&Sum='.$summ.'&cps_email='.$emailtopay.'" title="Наличными через терминал" target="_blank"><img width="299" height="50" alt="" src="https://paybylink.ru/invoice/assets/img/email_template/cash.png"></a>
																			</p>
																			<p style="text-align: center;margin-top:20px;margin-bottom:30px">
																				<a href="https://money.yandex.ru/eshop.xml?ShopID=666&scid=999&CustomerNumber='.$forwhat.'&customerEmail='.$emailtopay.'&paymentType=WM&Sum='.$summ.'&cps_email='.$emailtopay.'" title="С помощью Webmoney" target="_blank"><img width="299" height="50" alt="" src="https://paybylink.ru/invoice/assets/img/email_template/webmoney.png"></a>
																			</p>
																	</tr>
																		</td>
																	</tr>
																</table>
															</td>
															<td width="1" bgcolor="#E7E7E7"/>
														</tr>
													</table>
												</td>
												<td width="3"/>
											</tr>
											<tr><td colspan="3"><img src="https://paybylink.ru/invoice/assets/img/email_template/shadow.png" width="640" height="16" alt=""/></td></tr>
										</table>
									</td>
								</tr>
								<tr><td height="50"/></tr>
							</table>
						</td>
					</tr>
				</table>
			</body>
		'; 

		$headers  = "Content-type: text/html; charset=utf8 \r\n"; 

		mail($to, $subject, $message, $headers); 
		
		print "<script type=\"text/javascript\">"; 
		print "alert('Денежное письмо было успешно отправлено')"; 
		print "</script>"; 
				
	}
	
}
?>