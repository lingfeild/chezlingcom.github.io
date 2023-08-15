<?php

abstract class PurchaseHandler
{

    public function update_limits($userid, $amount)
    {
        $purchase_limits = $this->__nat_user_handler->get_purchase_limits($userid, $amount);
        $this->__nat_user_handler->update_daily_limits($userid, $amount, $purchase_limits['daily_start_date'], $purchase_limits['sum_daily_purchases']);
        $this->__nat_user_handler->update_monthly_limits($userid, $amount, $purchase_limits['monthly_start_date'], $purchase_limits['sum_monthly_purchases']);
        return;
    }

    /**************************************************************************************/

    public function validate_purchase_limits($userid, $amount)
    {
        $user_data = $this->__nat_user_handler->get_user_data($userid);
        if ($amount > $user_data['remaining_daily_limit'] || $amount > $user_data['remaining_monthly_limit'] || $amount > $user_data['transaction_limit']) {
            return false;
        }
        return true;
    }

}
