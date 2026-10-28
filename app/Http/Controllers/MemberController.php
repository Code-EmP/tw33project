<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $members = Member::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($memberQuery) use ($search): void {
                    $memberQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('level', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('members.index', compact('members', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Member::create($request->validate($this->rules()));

        return to_route('members.index')->with('success', 'Member added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member): View
    {
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member): View
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $member->update($request->validate($this->rules($member)));

        return to_route('members.show', $member)->with('success', 'Member details updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return to_route('members.index')->with('success', 'Member deleted permanently.');
    }

    public function deactivate(Member $member): RedirectResponse
    {
        $member->update(['is_active' => false]);

        return to_route('members.show', $member)->with('success', 'Member deactivated.');
    }

    /**
     * @return array<string, string>
     */
    private function rules(?Member $member = null): array
    {
        $emailRule = 'required|email|max:255|unique:members,email';

        if ($member !== null) {
            $emailRule .= ','.$member->id;
        }

        return [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'category' => 'required|string|max:100',
            'level' => 'required|string|max:100',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
