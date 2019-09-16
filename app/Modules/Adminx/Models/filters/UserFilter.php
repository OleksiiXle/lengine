<?php
namespace app\modules\adminxx\models\filters;

use app\models\DepartmentCommon;
use app\models\dictionary\Dictionary;
use app\modules\adminxx\models\UserData;
use app\modules\adminxx\models\UserM;
use yii\base\Model;

class UserFilter extends Model
{
    public $id;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $username;
    public $job_name;
    public $email;

    public $role;
    public $permission;
    private $_roleDict;

    /**
     * @return mixed
     */
    public function getRoleDict()
    {
        $roles = \Yii::$app->authManager->getRoles();
        $this->_roleDict['0'] = 'Не визначено';
        foreach ($roles as $role){
            $this->_roleDict[$role->name] = $role->name;
        }

        return $this->_roleDict;
    }
    public $permissionDict;
    public $additionalTitle = '';

    public $department_id;
    public $can_department;
    public $can_position;
    public $can_personal;

    public $spec_document;
    public $personal_id;
    public $direction;

    public $treeDepartment_id=0;
    public $treeDepartmentName = '';


    public $showStatusAll;
    public $showStatusActive;
    public $showStatusInactive;

    private $_filterContent;




    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['first_name', 'middle_name', 'last_name', 'role', 'username', 'job_name', 'email'], 'string', 'max' => 50],
            [['first_name', 'middle_name', 'last_name'],  'match', 'pattern' => UserM::USER_NAME_PATTERN,
                'message' => \Yii::t('app', UserM::USER_NAME_ERROR_MESSAGE)],
            [['username'],  'match', 'pattern' => UserM::USER_PASSWORD_PATTERN,
                'message' => \Yii::t('app', UserM::USER_PASSWORD_ERROR_MESSAGE)],
            [['job_name'],  'match', 'pattern' => DepartmentCommon::NAME_PATTERN,
                'message' => \Yii::t('app', DepartmentCommon::NAME_ERROR_MESSAGE)],

            [['id', 'department_id', 'direction', 'treeDepartment_id' ], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'spec_document', 'role'], 'string', 'max' => 50],
            [['treeDepartmentName'], 'string', 'max' => 500],
            ['spec_document',  'match', 'pattern' => '/^[0-9]{7}$/', 'message' => 'Введіть 7 цифр без пробілів!'],
            [[ 'showStatusAll', 'showStatusActive', 'showStatusInactive'], 'boolean'],
            ['email', 'email'],



        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логін',
            'first_name' => 'Імя',
            'middle_name' => 'По батькові',
            'last_name' => 'Прізвище',
            'phone' => 'Телефон',
            'auth_key' => 'Ключ авторізації',
            'password' => 'Пароль',
            'password_hash' => 'Пароль',
            'oldPassword' => 'Старий пароль',
            'retypePassword' => 'Підтвердждення паролю',
            'password_reset_token' => 'Токен збросу паролю',
            'departments' => 'Дозволені підрозділи',
            'email' => 'Email',
            'status' => 'Status',
            'created_at_str' => 'Створений',
            'updated_at_str' => 'Змінений',
            'time_login_str' => 'Увійшов',
            'time_logout_str' => 'Вийшов',
            'time_session_expire_str' => 'Час останньої дії',
            'direction' => 'Напрямок діяльності',
            'can_department' => 'Створення/редагування/видалення підрозділу',
            'can_position' => 'Створення/редагування/видалення посади',
            'can_personal' => 'Створення/редагування/видалення працівника',
            'role' => 'Роль користувача',
            'treeDepartmentName' => 'Місце роботи',
            'spec_document' => 'Жетон',
            'showStatusAll' => 'Всі',
            'showStatusActive' => 'Активні',
            'showStatusInactive' => 'Не активні',
            'job_name' => 'Підрозділ інший',


        ];
    }





    public function getQuery($params = null){

        $query = UserM::find()
            ->joinWith(['userDatas'])
          //  ->joinWith(['userDatas.personal']);
        ;
        if (!empty($this->department_id)) {
            $query ->joinWith([ 'userDepartments']);
        }

        if (!empty($this->role)) {
            $query ->innerJoin('auth_assignment aa', 'user.id=aa.user_id')
                ->innerJoin('auth_item ai', 'aa.item_name=ai.name')
                ->where(['ai.type' => 1])
            ;
        }

        if (!empty($this->treeDepartment_id) && $this->treeDepartment_id != 14005){
            $query->innerJoin('personal pers', 'user_data.personal_id=pers.id')
                ->innerJoin('department_parents dp', 'pers.department_id=dp.department_id')
                ->andWhere('dp.parent_id=' . $this->treeDepartment_id)
            ;

        }

        if (!$this->validate()) {
            return $query;
        }

        if (!empty($this->job_name)) {
            $query->andWhere(['LIKE', 'user_data.job_name', $this->job_name]);
        }

        if (!empty($this->email)) {
            $query->andWhere(['user.email' => $this->email]);
        }

        if (!empty($this->username)) {
            $query->andWhere(['user.username' => $this->username]);
        }

        if (!empty($this->role)) {
            $query->andWhere(['aa.item_name' => $this->role]);
        }

        if (!empty($this->department_id)) {
            $query->andWhere(['user_department.department_id' => $this->department_id]);
        }

        if (!empty($this->direction)) {
            $query->andWhere(['user_data.direction' => $this->direction]);
            $this->additionalTitle .= ' Напрямок *' . UserData::$directionArray[$this->direction] . '*' ;
        }

        if (!empty($this->spec_document)) {
            $query->andWhere(['user_data.spec_document' => $this->spec_document]);
        }

        if (!empty($this->first_name)) {
            $query->andWhere(['like', 'user_data.first_name', $this->first_name]);
        }

        if (!empty($this->middle_name)) {
            $query->andWhere(['like', 'user_data.middle_name', $this->middle_name]);
        }

        if (!empty($this->last_name)) {
            $query->andWhere(['like', 'user_data.last_name', $this->last_name]);
        }

        if ($this->showStatusActive =='1'){
            $query->andWhere(['user.status' => UserM::STATUS_ACTIVE]);
        }

        if ($this->showStatusInactive =='1'){
            $query->andWhere(['user.status' => UserM::STATUS_INACTIVE]);
        }




        //   $e = $query->createCommand()->getSql();





        return $query;


        $query = UserM::find()
            ->joinWith(['userDatas']);

        if (!empty($this->role)) {
            $query ->innerJoin('auth_assignment aa', 'user.id=aa.user_id')
                ->innerJoin('auth_item ai', 'aa.item_name=ai.name')
                ->where(['ai.type' => 1])
            ;
        }

        if (!$this->validate()) {
            return $query;
        }

        if (!empty($this->role)) {
            $query->andWhere(['aa.item_name' => $this->role]);
        }

        if (!empty($this->first_name)) {
            $query->andWhere(['like', 'user_data.first_name', $this->first_name]);
        }
        if (!empty($this->middle_name)) {
            $query->andWhere(['like', 'user_data.middle_name', $this->middle_name]);
        }
        if (!empty($this->last_name)) {
            $query->andWhere(['like', 'user_data.last_name', $this->last_name]);
        }
     //   $e = $query->createCommand()->getSql();
        return $query;
    }

    public function getFilterContent(){
        $this->_filterContent = '';

        if (!empty($this->first_name)) {
            $this->_filterContent .= ' Ім"я *' . $this->first_name . '*;' ;
        }

        if (!empty($this->middle_name)) {
            $this->_filterContent .= ' По-батькові *' . $this->middle_name . '*;' ;
        }

        if (!empty($this->last_name)) {
            $this->_filterContent .= ' Прізвище *' . $this->last_name . '*;' ;
        }

        if (!empty($this->username)) {
            $this->_filterContent .= ' Логін *' . $this->username . '*;' ;
        }

        if (!empty($this->email)) {
            $this->_filterContent .= ' Email *' . $this->email . '*;' ;
        }


        if (!empty($this->spec_document)) {
            $this->_filterContent .= ' Жетон *' . $this->spec_document . '*;' ;
        }

        if (!empty($this->role)) {
            $this->_filterContent .= ' Роль *' . $this->roleDict[$this->role] . '*;' ;
        }

        if (!empty($this->direction)) {
            $this->_filterContent .= ' Напрямок *' . UserData::$directionArray[$this->direction] . '*;' ;
        }

        if (!empty($this->treeDepartment_id) && $this->treeDepartment_id != 14005){
            $department = DepartmentCommon::findOne($this->treeDepartment_id);

            if (!empty($department) ){
                $this->_filterContent .= ' Підрозділ *' . $department->gunpName . '*;' ;

            }
        }

        if (!empty($this->job_name)) {
            $this->_filterContent .= ' Місце роботи (не аттест.) *' . $this->job_name . '*;' ;
        }

        if ($this->showStatusActive =='1'){
            $this->_filterContent .= ' * Тількі активні*;' ;
        }

        if ($this->showStatusInactive =='1'){
            $this->_filterContent .= ' * Тількі неактивні*;' ;
        }

        return $this->_filterContent;
    }

}