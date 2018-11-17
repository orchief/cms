<?php
// +----------------------------------------------------------------------
// | Description: 菜单管理
// +----------------------------------------------------------------------
// | Author: orchief
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\common\controller\Rest;
class Menus extends Rest
{
    public $modelName = 'Menu';
    public $index;
    public $read;
    public $save;
    public $update;
    public $delete;
    public $deletes;
    public $enables;

    /**
     * 下载菜单xml文件
     */
    public function createXml()
    {
        $data_array = Db('admin_menu')->select();
        //  属性数组
        $attribute_array = array(
            'title' => array(
                'size' => 1,
            ),
        );
        $string = <<<XML
<?xml version='1.0' encoding='utf-8'?>
<Menu>
</Menu>
XML;
        $xml = simplexml_load_string($string);
        foreach ($data_array as $data) {
            if ($data['pid'] == 0) {
                $item = $xml->addChild('Module');
                $item->addAttribute('Title', $data['title']);
                $item->addAttribute('Link', $data['url']);
                $temp_id = $data['id'];
                foreach ($data_array as $child) {
                    if ($child['pid'] == $temp_id) {
                        $child_node = $item->addChild('Item');
                        $child_node->addAttribute('Title', $child['title']);
                        $child_node->addAttribute('Link', $child['url']);
                        $child_node->addAttribute('icon', $child['icon']);
                        $child_node->addAttribute('privilege', $child['pid']);
                        $temp_child_id = $child['id'];
                        foreach ($data_array as $child_child) {
                            if ($child_child['pid'] == $temp_child_id) {
                                $child_child_node = $child_node->addChild('PageLink');
                                $child_child_node->addAttribute('Title', $child_child['title']);
                                $child_child_node->addAttribute('Link', $child_child['url']);
                                $child_child_node->addAttribute('privilege', $child_child['pid']);
                            }
                        }
                    }
                }

            }
        }
        $resXml = $xml->asXML();
        // $filename = 'menus/'.time().'.xml';
        // file_put_contents($filename, $resXml);
        $this->jsonData($resXml);
    }
}
