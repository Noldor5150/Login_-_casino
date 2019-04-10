<?php

namespace Core\User;

class User extends Abstracts\User {

    const ACC_TYPE_USER = 1;
    const ACC_TYPE_ADMIN = 0;

    public function __construct($data = null) {

        if (!$data) {
            $this->data = [
                'username' => null,
                'email' => null,
                'full_name' => null,
                'age' => null,
                'gender' => null,
                'orientation' => null,
                'photo' => null,
                'account_type' => null,
                'is_active' => null,
                'password' => null,
            ];
        } else {
            $this->setData($data);
        }
    }

    public function getAccountType(): int {
        return $this->data['account_type'];
    }

    public function getIsActive(): bool {
        return $this->data['is_active'];
    }

    public function getPassword(): string {
        return $this->data['password'];
    }

    public function setAccountType(int $account_type) {
        if (in_array($account_type, [self::ACC_TYPE_USER, self::ACC_TYPE_ADMIN])) {
            $this->data['account_type'] = $account_type;

            return true;
        }
    }

    public function setIsActive(bool $is_active) {
        $this->data['is_active'] = $is_active;
    }

    public function setPassword(string $password) {
        $this->data['password'] = $password;
    }

    public function setData(array $data) {
        $this->setUsername($data['username'] ?? '');
        $this->setEmail($data['email'] ?? '');
        $this->setFullName($data['full_name'] ?? '');
        $this->setAge($data['age'] ?? null);
        $this->setGender($data['gender'] ?? '');
        $this->setOrientation($data['orientation'] ?? '');
        $this->setPhoto($data['photo'] ?? '');
        $this->setAccountType($data['account_type'] ?? null);
        $this->setIsActive($data['is_active'] ?? null);
        $this->setPassword($data['password'] ?? '');
    }

    public function getData() {

        return $this->data;
    }

}
