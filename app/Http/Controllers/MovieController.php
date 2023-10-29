<?php

namespace App\Http\Controllers;

use App\Http\Docs\DTOSchema;
use App\Http\Docs\Schema\MovieDTO;
use App\Http\Docs\Schema\MovieListDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Movie\Application\Commands\GetDetailed\GetDetailedCommand;
use Movie\Application\Commands\GetDetailed\GetDetailedDTO;
use Movie\Application\Commands\GetList\GetListCommand;
use Movie\Application\Commands\GetList\GetListDTO;
use OpenApi\Annotations as OA;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\PathParameter;
use OpenApi\Attributes\Schema;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="Movie Controller", version="0.1")
 */
class MovieController extends Controller
{
    #[Get(
        '/api/movie/list',
        parameters: [
            new Parameter(
                name: 'page',
                in: 'query',
                required: true,
                schema: new Schema(type: 'integer')
            ),
            new Parameter(
                name: 'pageSize',
                in: 'query',
                required: true,
                schema: new Schema(type: 'integer')
            ),
        ]
    )]
    #[\OpenApi\Attributes\Response(
        response: Response::HTTP_OK,
        description: 'Movie List',
        content: new JsonContent(ref: DTOSchema::MOVIE_LIST_SCHEMA)
    )]
    public function getList(Request $request, GetListCommand $command): JsonResponse
    {
        ['movies' => $movieList, 'count' => $count] = $command(new GetListDTO(
            $request->input('page'),
            $request->input('pageSize')
        ));

        return response()->json(new MovieListDTO($movieList, $count));
    }

    #[Get(
        '/api/movie/{id}',
    )]
    #[\OpenApi\Attributes\Response(
        response: Response::HTTP_OK,
        description: 'Movie List',
        content: new JsonContent(ref: DTOSchema::MOVIE_DTO)
    )]
    public function get(
        #[PathParameter(schema: new Schema(type: 'integer'))] int $id,
        Request $request,
        GetDetailedCommand $command
    ): JsonResponse {
        return response()->json(new MovieDTO($command(new GetDetailedDTO($id))));
    }
}
