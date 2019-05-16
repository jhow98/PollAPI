<?php

namespace Api\Http\Controllers\Api;

use Illuminate\Http\Request;
use Api\Http\Controllers\Controller;
use Api\Poll;
use Api\Options;

/*
|--------------------------------------------------------------------------
| Classe controrladora principal. Possui todos os métodos para retorno dos endpoints solicitados.
|--------------------------------------------------------------------------
*/
class PollController extends Controller
{
    private $poll;

    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    public function show($id) //Retorna uma enquete e incrementa uma view a ela
    {
        $poll = $this->poll->find($id);

        if (!$poll) return response('', 404);
        $poll->views++;
        $poll->save();
        return response()->json(
            [
                'poll_id' => $poll->id,
                'poll_description' => $poll->description,
                'options' =>

                $poll->options()->select('id as option_id', 'description')->get()

            ]
        );
    }

    public function stats($id) // retorna o status de uma votação.
    {
        $poll = $this->poll->find($id);

        if (!$poll) return response('', 404);

        $data = [
            'views' => $poll->views,
            'votes' =>
            $poll->options()->select('id as option_id', 'qty')->get()

        ];
        return response()->json($data);
    }


    public function store(Request $request) // Cria uma votação, dados recebidos via POST
    {

        try {
            $r = $request->all();
            $p = $this->poll->create([
                'description' => $r['poll_description']
            ]);
            foreach ($r['options'] as $option) {
                Options::create([
                    'poll_id' => $p->id,
                    'description' => $option
                ]);
            }
            return response()->json(['poll_id' => $p->id], 201)->header('Location', 'poll/' . $p->id);;
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json($e->message(), 500);
            }
        }
    }

    public function vote($id) // Adiciona um voto a uma opção de uma determinada enquete.
    {
        try {
            $option = Options::find($id);
            $option->qty++;
            $option->save();
            return  $return = ['option_id' => $option->id];
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}

