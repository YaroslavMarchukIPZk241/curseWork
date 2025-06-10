<?php

namespace controllers;

use core\Controller;
use core\Core; 
use models\Ticket;
use models\PromoCode;
use models\PromoUser;

class TicketsController extends Controller
{
    public function actionIndex()
{
    $tickets = Ticket::findAll();
    $userId = $_SESSION['user']['id'] ?? null;
    
    $activePromoCode = null;
    $discountPercentage = 0;
    $discountedTickets = [];

    if ($userId) {
        $promoUser = PromoUser::getPromoCodeForUser($userId);
        
        if ($promoUser && isset($promoUser->id_promo)) {
            $promoCode = PromoCode::findById($promoUser->id_promo);
            
            if ($promoCode && $promoCode->isActive()) {
                $activePromoCode = $promoCode;
                $discountPercentage = $promoCode->discount_percentage;
                
                // Розраховуємо ціни зі знижкою для всіх квитків
                foreach ($tickets as $ticket) {
                    $ticket->original_price = $ticket->price;
                    $ticket->discounted_price = $ticket->price * (1 - $discountPercentage / 100);
                }
            }
        }
    }

    return $this->render('tickets/tickets', [
        'tickets' => $tickets,
        'activePromoCode' => $activePromoCode,
        'discountPercentage' => $discountPercentage
    ]);
}

    public function actionView($params)
    {
        
        $id = is_array($params) ? (int)$params[0] : (int)$params;
        $ticket = Ticket::findById($id);
        if (!$ticket) {
            return $this->redirect('/tickets/index');
        }

        $userId = $_SESSION['user']['id'] ?? null;
        $discountedPrice = $ticket->price;
        $activePromoCode = null;

        if ($userId) {
            $promoUser = PromoUser::getPromoCodeForUser($userId);
            if ($promoUser) {
                $promoCode = PromoCode::findById($promoUser->id_promo);
                if ($promoCode && $promoCode->isActive()) {
                    $activePromoCode = $promoCode;
                    $discountedPrice = $ticket->price * (1 - $promoCode->discount_percentage / 100);
                }
            }
        }

        return $this->render('tickets/viewTicket', [
            'ticket' => $ticket,
            'discountedPrice' => $discountedPrice,
            'activePromoCode' => $activePromoCode
        ]);
    }
}