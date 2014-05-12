<?php



/**
 *  Captcha component
 */

App::uses('Component', 'Controller');

class UploadComponent extends Component {



	public function __construct(){


	}

	public function create( $filename , $path , $width = 360 , $height = 360){

			// 设置最大宽高

			// Content type

			// 获取新尺寸
			list($width_orig, $height_orig , $type , $attr ) = getimagesize($filename);

			$ratio_orig = $width_orig/$height_orig;
			/**
			 * 1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，
			 * 9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM
			 */
			if ($width/$height > $ratio_orig) {
			   $width = $height*$ratio_orig;
			} else {
			   $height = $width/$ratio_orig;
			}

			// 重新取样
			$image_p = imagecreatetruecolor($width, $height);

			$image_fn = array(
				array(
					"create" => 'imagecreatefromgif',
					"out_put" => "imagegif"
					),
				array(
					"create" => 'imagecreatefromjpeg',
					'out_put'=> 'imagepng'
					),
				array(
					"create" => "imagecreatefrompng",
					"out_put" => "imagepng"
					)
				);


			$image = $image_fn[$type-1]["create"]($filename);

			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
			// 输出
			$image_fn[$type-1]["out_put"]($image_p, $path);


			imagedestroy($image_p);
			imagedestroy($image);

	}

	public function save(CakeRequest $request , $field = "files" )
	{
		$path = $request['form'][$field ]['name'];

		$extension = substr($path,strrpos($path,'.')+1);

		$uploadfile = 'src/'.md5(time().basename($request['form'][$field ]['name'])).".".$extension;

		$thumbnail = 'src/thumb/'.md5(time().basename($request['form'][$field ]['name']))."_thumb.".$extension;

		if(move_uploaded_file($request['form'][$field ]['tmp_name'], $uploadfile) ){
			
			$this->create($uploadfile , $thumbnail);
			
			return array(
				"file" => $uploadfile,
				"thumb" => $thumbnail
				);
		}
	}

}

?>