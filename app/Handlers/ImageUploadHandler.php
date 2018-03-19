<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/3/18
 * Time: 下午11:57
 */
namespace App\Handlers;

use Image;

class ImageUploadHandler
{
    //只允许以下后缀命的图片文件上传
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $folder, $file_prefix, $max_width)
    {
        //构建存储文件夹的规则，值如："uploads/images/avatar/201709/21/"
        //文件夹切割能让查找效率更高
        $folder_name = 'uploads/images/' . $folder . date('/Ym/d/', time());

        //文件具体的存储物理路径，'public_path()'为了获取public文件夹的物理路径。
        $upload_path = public_path() . '/' . $folder_name;

        //获取文件后缀名称，因图片从剪切板粘贴后缀为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        //拼接文件名称，加前缀是为了增加上传图片的辨析度，前缀可以是相关数据模型的ID
        //例如：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        //如果上传的文件后缀不在允许的范围内终止操作
        if( ! in_array($extension, $this->allowed_ext)){
            return false;
        }

        //将文件（图片）移动到对应的路径
        $file->move($upload_path, $filename);

        //如果限制了图片宽度，就进行裁剪
        if($max_width && $extension != 'gif'){

            //调用类中的方法，裁剪图片
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return[
            'path' => config('app.url') . '/' . $folder_name . $filename
        ];
    }

    public function reduceSize($file_path, $max_width){

        //传入图片实际物理路径实例化
        $image = Image::make($file_path);

        //进行大小调整操作
        $image->resize($max_width, null, function ($constraint){

            //设定宽度为$max_width，高度等比缩放
            $constraint->aspectRatio();

            //防止裁剪图片是，图片尺寸变大
            $constraint->upsize();
        });

        //对修改后的图片进行报错
        $image->save();
    }
}