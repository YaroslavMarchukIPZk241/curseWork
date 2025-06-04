<?php

namespace controllers;

use core\Controller;
use models\Ticket;

class TicketsController extends Controller
{
    public function actionIndex()
    {
        $tickets = Ticket::findAll();
        return $this->render('tickets/tickets', ['tickets' => $tickets]);
    }

    public function actionView($params)
    {
        $id = is_array($params) ? (int)$params[0] : (int)$params;
        $ticket = Ticket::findById($id);
        if (!$ticket) {
            return $this->redirect('/tickets/index');
        }
        return $this->render('tickets/viewTicket', ['ticket' => $ticket]);
    }
}
