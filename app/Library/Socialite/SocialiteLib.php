<?php
namespace App\Library\Socialite;

use App\Consts\Common\WhetherConst;
use App\Library\Socialite\Consts\UserSocialiteConst;
use  App\Library\Socialite\Model\UsersSocialiteModel;
use App\Library\Socialite\Consts\ResultConst;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * 联合登录
 */
class SocialiteLib
{
    public  function socialiteCallback($oauthUser, $type = "", Request $request = null)
    {
        if (empty($oauthUser->getId())) {
              throwException(new LogicException(1010040));
        }

        $user_id = 0;
        $user = Auth::guard('forum')->user();
        if ($user) {
            $user_id = $user->id;
        }

        UsersSocialiteModel::query()->where("socialite_uid", $oauthUser->getId())->lockForUpdate()->get();

        $userSocialiteModel = new UsersSocialiteModel();
        $userSocialiteModel->socialite_uid = $oauthUser->getId();
        $userSocialiteModel->nickname = $oauthUser->getNickname();
        $userSocialiteModel->name = $oauthUser->getName();
        $userSocialiteModel->email = $oauthUser->getEmail();
        $userSocialiteModel->avatar = $oauthUser->getAvatar();
        $userSocialiteModel->created_ip = $request->getClientIp();
        $userSocialiteModel->type = $type;
        $userSocialiteModel->user_id = $user_id;
        $userSocialiteModel->unionid = isset($oauthUser->unionid) && !empty($oauthUser->unionid) ? $oauthUser->unionid : '';
        $userSocialite = $this->socialiteCallbacks($userSocialiteModel);


//                UsersSocialiteModel::query()->where("socialite_uid", $oauthUser['socialite_uid'])->lockForUpdate()->get();
//
//                $userSocialiteModel = new UsersSocialiteModel();
//                $userSocialiteModel->socialite_uid = $oauthUser['socialite_uid'];
//                $userSocialiteModel->nickname = $oauthUser['nickname'];
//                $userSocialiteModel->name = $oauthUser['name'];
//                $userSocialiteModel->email = $oauthUser['email'];
//                $userSocialiteModel->avatar = $oauthUser['avatar'];
//                $userSocialiteModel->created_ip = $request->getClientIp();
//                $userSocialiteModel->type = $type;
//                $userSocialiteModel->user_id = $user_id;
//                $userSocialiteModel->unionid = '';
//                $userSocialite = $this->socialiteCallbacks($userSocialiteModel);

        if(!is_object($userSocialite)) {
            if($userSocialite == ResultConst::USER_SOCIALITE_NOT_FOUND) {
                $userSocialiteModel->save();
                $userSocialite = $userSocialiteModel;
            } else {
                return $this->getErrorView($type, $userSocialite);
            }
        }

        if ($userSocialite->user) {
            if (empty($user)) {
                // 未登陆用户，直接登陆
                $user = $userSocialite->user;

                if($user->status != WhetherConst::NO){
                    Auth::guard('forum')->login($user);

                }else{
                    return $this->getErrorView($type, ResultConst::USER_UNABLE);
                }
                return redirect($this->getHome());
            }

        } else {

            // 记录第三方登录用户
            $login_socialite_ids = $userSocialite->id;

            session([
                UserSocialiteConst::SOCIALITE_SESSION_KEY => $login_socialite_ids
            ]);

            // 绑定页面
            return redirect(route('f.auth.bind'));
        }
    }

    protected  function socialiteCallbacks($userSocialiteModel)
    {
        $socialite_uid = $userSocialiteModel->socialite_uid;
        if (empty($socialite_uid)) {
             return ResultConst::USER_SOCIALITE_UID_LOST_PARAM;
        }

        $type = $userSocialiteModel->type;
        if (empty($type)) {
             return ResultConst::USER_SOCIALITE_TYPE_LOST_PARAM;
        }

        $userSocialite = UsersSocialiteModel::where('socialite_uid', $socialite_uid)->where("type", $type)->first();

        if (empty($userSocialite)) {
          return ResultConst::USER_SOCIALITE_NOT_FOUND;
        }
        return $userSocialite;
    }

    public function getSocialiteUser($siteName = "", $type = 0)
    {
        try {
            $oauthUser = Socialite::with($siteName)->user();
            return $oauthUser;
        } catch (\Exception $e) {}
        //return $this->getErrorView($type, ResultConst::USER_SOCIALITE_REQUIRE_USER_ERROR);
    }

    public function getErrorView($type, $a)
    {

        if(isMobile()) {
            return redirect(route('f.member.index'));
        } else {
            return redirect(route('h.member.index'));
        }
    }

    public function bindUser($email, $userSocialiteId)
    {
        $usersModel = User::where('email', $email)->first();
        $usersSocialiteModel = $this->usersSocialiteFind($userSocialiteId);

        if(!$usersSocialiteModel) {
            return false;
        }

        if(is_object($usersModel)) {
            $usersSocialiteModel->user_id = $usersModel->id;
            return $usersSocialiteModel->save();
        } else {
            $model = new User();
            $model->email = $email;
            $model->password = bcrypt(Str::random(60));
            $model->status = WhetherConst::YES;
            $model->remember_token = Str::random(60);
            $model->name = $usersSocialiteModel->nickname;
            $model->save();

            $usersSocialiteModel->user_id = $model->id;
            return $this->createUser($usersSocialiteModel, $email);
        }
    }

    public function createUser($usersSocialiteModel, $email = '')
    {
        $model = new User();
        $model->email = $email;
        $model->password = bcrypt(Str::random(60));
        $model->status = WhetherConst::YES;
        $model->remember_token = Str::random(60);
        $model->name = $usersSocialiteModel->nickname;
        $model->save();

        $usersSocialiteModel->user_id = $model->id;
        return $usersSocialiteModel->save();
    }

    public function login($userSocialiteId)
    {
        $usersSocialiteModel = $this->usersSocialiteFind($userSocialiteId);
        if (! empty($usersSocialiteModel->user->id)) {
            if (empty($user)) {
                // 未登陆用户，直接登陆
                $user = $usersSocialiteModel->user;

                if($user->status != WhetherConst::NO){
                    Auth::guard('forum')->login($user);
                } else {
                    return $this->getErrorView($usersSocialiteModel->type, ResultConst::USER_UNABLE);
                }
                return redirect($this->getHome());
            }
        }

        return redirect(route('f.auth.bind'));
    }

    public function getHome()
    {
        if(isMobile()) {
            return route('h.home');
        } else {
            return route('f.home');
        }
    }

    public function getMember()
    {
        if(isMobile()) {
            return route('f.member.index');
        } else {
            return route('h.member.index');
        }
    }

    public function usersSocialiteFind($userSocialiteId)
    {
        return UsersSocialiteModel::find($userSocialiteId);
    }

}