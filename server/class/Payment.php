<?php

# класс, полностью обслуживающий как создание, так и выполнение транзакций
// создать транзакцию, сформировать ссылку на ПС, получить ответ от ПС, записать транзакцию, присвоить статус

class Payment {
    public $data = array();
    public function newTransaction($userID,$statusID,$summ) {
        $trans = R::dispense('transaction');
        $trans->user = $userID;
        $trans->status = $statusID;
        $trans->summ = $summ;
        $trans->timingon = date('Y-m-d H:i:s');
        R::store($trans);
        $id = R::getInsertID();
        return $id;
    }
}