pragma solidity ^0.4.4;

contract GreatContract {
    address private contractOwner;
    uint256 private tokenPrice;
    uint256 private numberOfAllTokens;
    uint256 private numberOfAvailableTokens;
    uint256 private numberOfSoldTokens;

    constructor() public {
        contractOwner = msg.sender;
        tokenPrice = 115;
        numberOfAllTokens = 90;
        numberOfSoldTokens = 28;
        numberOfAvailableTokens = numberOfAllTokens - numberOfSoldTokens;
    }

    modifier OnlyContractOwner {
        require(msg.sender == contractOwner);
        _;
    }

    function() external payable {
    }

	function buyTokens(uint256 amount) external payable {
	    require(amount <= numberOfAvailableTokens);
        numberOfSoldTokens += amount;
        numberOfAvailableTokens -= amount;
	}

    function getContractOwner() external constant returns (address) {
        return (contractOwner);
    }

    function getTokenPrice() external constant returns (uint256) {
        return (tokenPrice);
    }

    function setTokenPrice(uint256 value) external OnlyContractOwner {
        tokenPrice = value;
    }

    function getNumberOfAllTokens() external constant returns (uint256) {
        return numberOfAllTokens;
    }

    function getNumberOfAvailableTokens() external OnlyContractOwner constant returns (uint256) {
        return numberOfAvailableTokens;
    }

    function getNumberOfSoldTokens() external OnlyContractOwner constant returns (uint256) {
        return numberOfSoldTokens;
    }

    function setNumberOfAllTokens(uint256 value) external OnlyContractOwner {
        require(value >= numberOfSoldTokens);
        numberOfAllTokens = value;
        numberOfAvailableTokens = numberOfAllTokens - numberOfSoldTokens;
    }

    function setNumberOfAvailableTokens(uint256 value) external OnlyContractOwner {
        require(value <= numberOfSoldTokens);
        numberOfAvailableTokens = numberOfAvailableTokens + value;
        numberOfSoldTokens = numberOfAllTokens - numberOfAvailableTokens;
    }

    function setContractOwner(address _address) external OnlyContractOwner {
        contractOwner = _address;
    }
}