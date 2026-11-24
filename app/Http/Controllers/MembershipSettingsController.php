<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MembershipSettingsController extends Controller
{
    public function index(): View
    {
        return view('membership-settings.index', [
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('fee')->get(),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        MembershipCategory::create($request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:membership_categories,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ]));

        return to_route('membership-settings.index')->with('success', 'Membership category added.');
    }

    public function updateCategory(Request $request, MembershipCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('membership_categories', 'name')->ignore($category)],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $category->update($validated);

        return to_route('membership-settings.index')->with('success', 'Membership category updated.');
    }

    public function destroyCategory(MembershipCategory $category): RedirectResponse
    {
        $isAssigned = Member::query()
            ->where('membership_category_id', $category->id)
            ->orWhere('category', $category->name)
            ->exists();

        if ($isAssigned) {
            return to_route('membership-settings.index')->with(
                'error',
                'This category is assigned to one or more members. Deactivate it instead to preserve membership history.'
            );
        }

        $categoryName = $category->name;
        $category->delete();

        return to_route('membership-settings.index')->with(
            'success',
            "Membership category {$categoryName} removed."
        );
    }

    public function storeLevel(Request $request): RedirectResponse
    {
        MembershipLevel::create($request->validate($this->levelRules()));

        return to_route('membership-settings.index')->with('success', 'Membership level added.');
    }

    public function updateLevel(Request $request, MembershipLevel $level): RedirectResponse
    {
        $validated = $request->validate($this->levelRules($level));
        $validated['is_active'] = $request->boolean('is_active');
        $level->update($validated);

        return to_route('membership-settings.index')->with('success', 'Membership level updated.');
    }

    public function destroyLevel(MembershipLevel $level): RedirectResponse
    {
        if (MembershipTransaction::where('membership_level_id', $level->id)->exists()) {
            return to_route('membership-settings.index')->with(
                'error',
                'This membership level cannot be removed because purchase history references it.'
            );
        }

        $levelName = $level->name;
        $level->delete();

        return to_route('membership-settings.index')->with(
            'success',
            "Membership level {$levelName} removed."
        );
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function levelRules(?MembershipLevel $level = null): array
    {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('membership_levels', 'name')->ignore($level)],
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_period' => ['required', 'string', 'max:100'],
            'benefits' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
