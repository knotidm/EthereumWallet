pragma solidity ^0.4.4;

contract GreatContract {
    address private contractOwner;
    uint256 private tokenPrice;
    uint256 private numberOfAllTokens;
    uint256 private numberOfAvailableTokens;
    uint256 private numberOfSoldTokens;

    function GreatContract() public {
        contractOwner = msg.sender;
        tokenPrice = 100;
        numberOfAllTokens = 72;
        numberOfSoldTokens = 0;
        numberOfAvailableTokens = numberOfAllTokens - numberOfSoldTokens;
    }

    modifier OnlyContractOwner {
        require(msg.sender == contractOwner);
        _;
    }

    function() external payable {
    }

	function buyTokens(uint256 amount) external {
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

    function setContractOwner(address _address) external OnlyContractOwner {
        contractOwner = _address;
    }
}