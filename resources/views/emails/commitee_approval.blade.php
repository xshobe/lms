Dear {{$model->Customer->first_name}},<br>
 You request of loan for the amount of {{$model->loan_amount}}$ has been {{$loan_status[$model->status]}}