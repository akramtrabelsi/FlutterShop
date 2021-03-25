<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){
        $tickets = Ticket::with(['ticketType','customer','order'])->simplePaginate(env('PAGINATION',16));
        return view('admin.tickets.tickets')->with(['tickets'=>$tickets]);
    }
}
