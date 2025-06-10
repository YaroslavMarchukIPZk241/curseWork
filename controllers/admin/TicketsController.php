<?php

namespace controllers\admin;

use core\Controller;
use models\Ticket;

class TicketsController extends Controller
{
public function actionIndex()
{
    $tickets = Ticket::findAll(); 
    return $this->render('admin/tickets/index', ['tickets' => $tickets]);
}

    public function actionCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ticketModel = new Ticket();
            $ticketModel->insert([
                'title' => $_POST['title'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
                'available_at' => $_POST['available_at'],
            ]);
            return $this->redirect('/admin/tickets');
        }

        return $this->render('admin/tickets/create');
    }

    public function actionEdit($params)
    {
        $id = is_array($params) ? (int)$params[0] : (int)$params;
        $ticketModel = new Ticket();
       $ticket = Ticket::findById($id);

        if (!$ticket) {
            return $this->redirect('/admin/tickets');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ticketModel->update($id, [
                'title' => $_POST['title'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
                'available_at' => $_POST['available_at'],
            ]);
            return $this->redirect('/admin/tickets');
        }

        return $this->render('admin/tickets/edit', ['ticket' => $ticket]);
    }

    public function actionDelete($params)
    {
        $id = is_array($params) ? (int)$params[0] : (int)$params;
        $ticketModel = new TicketModel();
        $ticketModel->delete($id);
        return $this->redirect('/admin/tickets');
    }
}
