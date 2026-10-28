<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
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
                        ->orWhere('level', 'like', "%{$search}%")
                        ->orWhereHas('membershipCategory', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('membershipLevel', fn ($query) => $query->where('name', 'like', "%{$search}%"));
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
        return view('members.create', [
            'categories' => MembershipCategory::where('is_active', true)->orderBy('name')->get(),
            'levels' => MembershipLevel::where('is_active', true)->orderBy('fee')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $this->syncMembershipNames($validated);
        Member::create($validated);

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
        if ($member->membership_category_id === null && $member->category !== null) {
            $member->setAttribute('membership_category_id', MembershipCategory::where('name', $member->category)->value('id'));
        }

        if ($member->membership_level_id === null && $member->level !== null) {
            $member->setAttribute('membership_level_id', MembershipLevel::where('name', $member->level)->value('id'));
        }

        return view('members.edit', [
            'member' => $member,
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('fee')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate($this->rules($member));
        $this->syncMembershipNames($validated);
        $validated['is_active'] = $request->boolean('is_active');
        $member->update($validated);

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
            'membership_category_id' => 'required|exists:membership_categories,id',
            'membership_level_id' => 'required|exists:membership_levels,id',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function syncMembershipNames(array &$validated): void
    {
        $validated['category'] = MembershipCategory::findOrFail($validated['membership_category_id'])->name;
        $validated['level'] = MembershipLevel::findOrFail($validated['membership_level_id'])->name;
    }
}
