<table width="100%">
	<tr>
		<td align="left">
		<p>Сколько будет 2*2?</p>
		<form action='<?php echo $_SERVER['REQUEST_URI']?>' method='POST'>
			<input type='radio' name='answer' value='a1'>3<br>
			<input type='radio' name='answer' value='a2'>4<br>
			<input type='radio' name='answer' value='a3'>5<br>
				<input type='submit' value='Answer #1'>
		<!-- скрытые поля -->		
			<input type='hidden' name='title' value='Ответьте на вопрос №2'>
			<input type='hidden' name='question' value='<?= ++$question ?>'> 
		</form>
		</td>
	</tr>
</table>