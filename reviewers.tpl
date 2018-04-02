
{* Suggested Reviewers *}
<div id="reviewers">
	<h3>Preferred Reviewers</h3>
	<p>
		recommend reviewers
	</p>
	<table class="data fancy input">
		<tr valign="top">
			<th class="first">
				<label for="reviewerFirstName">
				{translate key="author.submit.reviewers.firstName"}*
				</label>
			</th>
			<th>
				<label for="reviewerLastName">
				{translate key="author.submit.reviewers.lastName"}*
				</label>
			</th>
			<th>
				<label for="reviewerInstitution">
				{translate key="author.submit.reviewers.institution"}*
				</label>
			</th>
			<th>
				<label for="reviewerEmail">
				{translate key="author.submit.reviewers.email"}*
				</label>
			</th>
			<th class="last">
				<label for="reviewerPreferred">
				{translate key="author.submit.reviewers.preferred"}
				</label>
			</th>
		</tr>
		{assign var="reviewerNum" val=0}
		<tr class="{cycle values="pl, alt"} reviewer{$reviewerNum++}">
			<td class="value"><input type="text" name="reviewer{$reviewerNum}FirstName" id="reviewer{$reviewerNum}FirstName" class="textField" value="{$reviewer1FirstName[$locale]|escape}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}LastName" id="reviewer{$reviewerNum}LastName" class="textField" value="{$reviewer1LastName[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}Institution" id="reviewer{$reviewerNum}Institution" class="textField" value="{$reviewer1Institution[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}Email" id="reviewer{$reviewerNum}Email" class="textField" value="{$reviewer1Email[$locale]}"></td>
			<td class="value checkbox"><input type="checkbox" name="reviewer{$reviewerNum}Preferred" id="reviewer{$reviewerNum}Preferred" class="checkbox" value="preferred" {if $reviewer1Preferred[$locale]} checked="checked"{/if}></td>
		</tr>
		<tr class="{cycle values="pl, alt"} reviewer{$reviewerNum++}">
			<td class="value"><input type="text" name="reviewer{$reviewerNum}FirstName" id="reviewer{$reviewerNum}FirstName" class="textField" value="{$reviewer2FirstName[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}LastName" id="reviewer{$reviewerNum}LastName" class="textField" value="{$reviewer2LastName[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}Institution" id="reviewer{$reviewerNum}Institution" class="textField" value="{$reviewer2Institution[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}Email" id="reviewer{$reviewerNum}Email" class="textField" value="{$reviewer2Email[$locale]}"></td>
			<td class="value checkbox"><input type="checkbox" name="reviewer{$reviewerNum}Preferred" id="reviewer{$reviewerNum}Preferred" class="checkbox" value="preferred"{if $reviewer2Preferred[$locale]} checked="checked"{/if}></td>
		</tr>
		<tr class="{cycle values="pl, alt"} reviewer{$reviewerNum++}">
			<td class="value"><input type="text" name="reviewer{$reviewerNum}FirstName" id="reviewer{$reviewerNum}FirstName" class="textField" value="{$reviewer3FirstName[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}LastName" id="reviewer{$reviewerNum}LastName" class="textField" value="{$reviewer3LastName[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}Institution" id="reviewer{$reviewerNum}Institution" class="textField" value="{$reviewer3Institution[$locale]}"></td>
			<td class="value"><input type="text" name="reviewer{$reviewerNum}Email" id="reviewer{$reviewerNum}Email" class="textField" value="{$reviewer3Email[$locale]}"></td>
			<td class="value checkbox"><input type="checkbox" name="reviewer{$reviewerNum}Preferred" id="reviewer{$reviewerNum}Preferred" class="checkbox" value="preferred"{if $reviewer3Preferred[$locale]} checked="checked"{/if}></td>
		</tr>
	</table>
</div>