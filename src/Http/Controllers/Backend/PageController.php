<?php

namespace MediaWebId\Starterkit\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use MediaWebId\Starterkit\Http\Requests\Page\PageRequest;
use MediaWebId\Starterkit\Http\Resources\Backend\PageResource;
use MediaWebId\Starterkit\Models\Page;
use Facades\MediaWebId\Starterkit\Http\Repositories\PageRepository;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {

        $pages = PageRepository::paginate(20);

        return Inertia::render('page/index', [
            'pages' => PageResource::collection($pages),
            'type' => type(),
            'title' => request('trash') ? 'Trash' : 'Page',
            'trash' => request('trash') ? true : false,
            'request' => request()->all(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Page',
                    'url' => route('page.index'),
                ],
            ],
        ]);
    }

    /**
     * create view.
     */
    public function create()
    {
        $page = new Page();
        $page = PageResource::make($page)->resolve();
        $templates = pageTemplates();

        return Inertia::render(''.vueFormExist(type(), 'page', 'form'), [
            'page' => $page,
            'type' => type(),
            'method' => 'store',
            'templates' => $templates,
            'title' => 'Create Page',
            'locale' => app()->getLocale(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Page',
                    'url' => route('page.index'),
                ],
            ],
        ]);
    }

    /**
     * store data.
     */
    public function store(PageRequest $request)
    {

        $page = Page::create($request->all());

        Cache::tags(['pages'])->flush();

        return redirect()->back()->with('message', toTitle($page->title).' has been updated');
    }

    /**
     * Edit view.
     */
    public function edit(Page $page)
    {
        $templates = pageTemplates();
        return Inertia::render(vueFormExist(type(), 'page', 'form'), [
            'page' => PageResource::make($page)->resolve(),
            'templates' => $templates,
            'type' => type(),
            'method' => 'update',
            'title' => 'Edit '.'Page',
            'locale' => app()->getLocale(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Page',
                    'url' => route('page.index'),
                ],
            ],
        ]);
    }

    /**
     * Update Data.
     */
    public function update(PageRequest $request, Page $page)
    {
        $page->update($request->all());


        Cache::tags(['pages'])->flush();

        return redirect()->back()->with('message', toTitle($page->title).' has been updated');
    }

    /**
     * Remove the specified resource from storage temporary.
     */
    public function delete($page)
    {
        $page = Page::find($page);
        if (!$page) {
            return abort(404);
        }
        $page->delete();

        Cache::tags(['pages'])->flush();

        return redirect()->route('page.index')->with('message', toTitle($page->title.' hase been deleted'));
    }

    /**
     * Remove data permanently.
     */
    public function destroy($page)
    {
        $page = Page::withTrashed()->find($page);
        if (!$page) {
            return abort(404);
        }
        $page->forceDelete();

        Cache::tags(['pages'])->flush();

        return redirect()->route('page.index')->with('message', toTitle($page->title.' hase been destroyed'));
    }

    public function destroyAll()
    {
        $ids = explode(',', request('selected'));
        $pages = Page::whereIn('_id', $ids)->withTrashed()->get();
        foreach ($pages as $page) {
            $page->forceDelete();
        }
        Cache::tags(['pages'])->flush();

        return redirect()->route('page.index')->with('message', toTitle($page->title).' has been destroyed');
    }

    /**
     * Restore Data from trash.
     */
    public function restore($page)
    {
        $page = Page::withTrashed()->find($page);
        if (!$page) {
            return abort(404);
        }
        $page->restore();
        Cache::tags(['pages'])->flush();

        return redirect()->route('page.index')->with('message', toTitle($page->title).' has been restored');
    }
}
