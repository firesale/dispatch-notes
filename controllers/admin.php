<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	public function print_notes($order = NULL)
	{
		// Laod stuff
		$this->load->model(array(
			'firesale/orders_m',
			'firesale/products_m',
			'firesale/categories_m',
			'notes_m'
		));

		$func_args = func_get_args();

		$orders = empty($func_args) ? $this->input->post('action_to') : $func_args;

		if ( ! empty($orders))
		{
			$content = NULL;

			foreach ($orders as $order_id)
			{
				// Set some default template stuff
				$this->template
					 ->enable_parser(TRUE)
					 ->set_layout(FALSE);

				$order = $this->notes_m->get_order($order_id);

				if ($order)
					$content .= $this->template->build('note', $order, TRUE);
			}

			$this->template->set_layout(FALSE)
						   ->set('content', $content)
						   ->append_css('module::print.css')
						   ->build('global');
		}
		else
		{
			redirect('admin/firesale/orders');
		}
	}
}