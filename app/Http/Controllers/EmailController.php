<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailManage;
use FontLib\Table\Type\loca;
use PharIo\Manifest\Email;

use function PHPUnit\Framework\isNull;

class EmailController extends Controller
{
    public function getemailitems(Request $request) {
        $itemId     = $request->itemId;
        $sectionId  = $request->sectionId;
        $isFlagged  = $request->isFlagged;

        $alldatas   = [];

        if($isFlagged == 0 && $sectionId == 0) {
            $alldatas = EmailManage::where('location', $itemId)->where('folder', 0)->get();
        }
        else if($isFlagged == 1) {
            $alldatas = EmailManage::where('flag', 1)->get();
        }
        else if($sectionId == 1) {
            if($itemId != 6)
                $alldatas = EmailManage::where('folder', 1)->where('location', $itemId)->get();
            else
                $alldatas = EmailManage::where('folder', 1)->where('location', '<', 6)->get();
        }

        return $alldatas;
    }

    public function boxcount() {
        $count = [];
        $key = 0;
        $cnt = 0;
        
        for($i = 0; $i < 10; $i++) {
            if($i > 5) $key = 1;
            $count[$i] = EmailManage::where('location', $i)->where('folder', $key)->count();
            $cnt += $count[$i];
        }
        $count[6] = EmailManage::get('folder', 1)->count() - $cnt;
        $count[1] = EmailManage::where('flag', 1)->count();
        return $count;
    }

    public function setflaggeditem($id) {
        $flagged = EmailManage::where('id', $id)->first()->flag;
        if(is_null($flagged) == false) {
            $flagged == 1 ? $flagged = 0 : $flagged = 1;
            EmailManage::where('id', $id)->update(['flag' => $flagged]);
        }
        return "";
    }

    public function setreaditems(Request $request) {
        $ids = explode(",", $request->id);
        $values = explode(",", $request->value);
        
        foreach ($ids as $key => $id) {
            if($values[$key] == "true") {
                EmailManage::where('id', $id)->update(['read' => '1']);
            }
        }
    }

    public function movetofolder(Request $request) {
        $ids = explode(",", $request->id);
        $values = explode(",", $request->value);

        foreach ($ids as $key => $id) {
            if($values[$key] == "true") {
                EmailManage::where('id', $id)->update(['folder' => '1']);
            }
        }
    }

    public function deletemail(Request $request) {
        $ids = explode(",", $request->id);
        $values = explode(",", $request->value);

        foreach ($ids as $key => $id) {
            if($values[$key] == "true") {
                EmailManage::where('id', $id)->delete();
            }
        }  
    }
}
